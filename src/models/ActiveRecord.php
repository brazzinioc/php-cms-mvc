<?php

declare(strict_types=1);

namespace Models;

use PDO;
use PDOException;
use Config\Database;
use Interfaces\CrudInterface;


abstract class ActiveRecord extends Database implements CrudInterface
{

  protected static $tableName = "";
  protected static $errors = [];

  public function __construct()
  {
    parent::__construct();
  }

  protected function validateData()
  {
  }

  protected function getErrors(): array
  {
    return static::$errors;
  }

  public final function save(): bool
  {
    $result = false;
    if (is_null($this->id)) {
      $result = $this->create();
    } else {
      $result = $this->update();
    }

    return $result;
  }

  public function create(): bool
  {
    return false;
  }

  public function update(): bool
  {
    return false;
  }

  /**
   * Delete a row in database table
   * @return bool
   */
  public function delete(): bool
  {
    $result = false;

    if (!is_null($this->id)) {

      try {

        parent::connectDB();

        $query = "DELETE FROM " . static::$tableName . " WHERE id = :id";
        $stmt = $this->dbConn->prepare($query);
        $stmt->bindParam(':id', $this->id, PDO::PARAM_INT);
        $result = $stmt->execute();

        parent::closeConnDB();
      } catch (PDOException $e) {
        saveLog($e->getMessage(), ActiveRecord::class);
      }
    }

    return $result;
  }

  /**
   * Get all row from database table
   * @return array
   */
  protected function all(): array
  {
    parent::connectDB();

    $query = "SELECT * FROM " . static::$tableName . " ORDER BY id";
    $objs = $this->executeSelectQuery($query, true);

    parent::closeConnDB();

    return $objs;
  }

  /**
   * Search a row with Id in database table
   * @param int $id
   * @return object
   */
  protected function findById(int $id): object
  {
    $obj = new static; //new obj from child class , with empty properties

    if ($id > 0) {
      try {

        parent::connectDB();

        $query = "SELECT * FROM " . static::$tableName . " WHERE id = $id";

        $objs = $this->executeSelectQuery($query, false);

        if (is_array($objs) && sizeof($objs) > 0) {
          $obj = array_shift($objs); // get first element from objects array
        }

        parent::closeConnDB();

      } catch (PDOException $e) {
        saveLog($e->getMessage(), ActiveRecord::class);
      }
    }

    return $obj;
  }


  /**
   * Execute a query Select and return an array of objects.
   * @param string $query
   * @param bool $allRows
   */
  protected final function executeSelectQuery(string $query, bool $allRows = true): array
  {
    $objs = [];

    if (strlen($query) > 0) {

      parent::connectDB();

      $stmt = $this->dbConn->prepare($query);
      $result = $stmt->execute();

      if ($result) {
        if ($allRows) {
          $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

          if (isset($rows) && is_array($rows) && sizeof($rows) > 0) {

            foreach ($rows as $row) {
            
              $obj = $this->madeObject($row);
            
              if ($obj instanceof static) {
                array_push($objs, $obj);
              }
            }
          }
        } else {
          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          if (isset($row) && is_array($row) && sizeof($row) > 0) {

            $obj = $this->madeObject($row);
            
            if ($obj instanceof static) {
              array_push($objs, $obj);
            }
          }
        }
      }

      parent::closeConnDB();
    }

    return $objs;
  }


  /**
   * Made a Object from an array.
   * @param array $row
   * @return object
   */
  protected final function madeObject(array $row): object
  {
    if (is_array($row) && sizeof($row) > 0) {

      $obj = new static; // new obj from child class , with empty properties

      foreach ($row as $key => $value) {
        if (property_exists($obj, $key)) { //validate if object has propertie in the key row
          $obj->$key = $value; // set value to object propertie
        }
      }

      return $obj;
    }
  }


  /**
   * Syncronize data from array to object
   * @param array $args
   * @return void
   */
  protected final function sincronizeObj(array $args = []): void
  {
    foreach ($args as $key => $value) {
      if (property_exists($this, $key) && !is_null($value)) {
        $this->$key = $value;
      }
    }
  }
}
