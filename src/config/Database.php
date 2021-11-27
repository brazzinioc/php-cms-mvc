<?php

declare(strict_types=1);


namespace Config;

use PDO;
use PDOException;
use Exception;


class Database
{
  private $dbDriver;
  private $dbHostname;
  private $dbName;
  private $dbUsername;
  private $dbPassword;
  private $dbPort;

  protected $dbConn;

  public function __construct()
  {
    try {

      $this->dbDriver = DB_DRIVER;
      $this->dbHostname = DB_HOSTNAME;
      $this->dbName = DB_NAME;
      $this->dbUsername = DB_USER;
      $this->dbPassword = DB_PASSWORD;
      $this->dbPort = DB_PORT;

    } catch (Exception $e) {
      
      saveLog($e->getMessage(), Database::class);

    }
  }

  protected function connectDB()
  {

    try {

      $dsn = $this->dbDriver . ":host=" . $this->dbHostname . ";port=" . $this->dbPort . ";dbname=" . $this->dbName;
      $this->dbConn = new PDO($dsn, $this->dbUsername, $this->dbPassword);
      
    } catch (PDOException $e) {
    
      saveLog($e->getMessage(), Database::class);
    
    }
  }

  protected function closeConnDB()
  {
    $this->dbConn = null;
  }
}
