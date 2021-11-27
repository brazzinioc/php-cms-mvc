<?php

declare(strict_types=1);


namespace Models;

use Exception;
use PDO;
use PDOException;
use Models\{ActiveRecord, ExternalApi};

class Auth extends ActiveRecord
{

  private $email;
  private $password;
  private $captchaToken;

  protected static $tableName = 'users';
  protected static $errors = [];


  public function __construct(string $email, string $password, string $captchaToken)
  {
    $this->email = filter_var($email, FILTER_SANITIZE_EMAIL) ?? null;
    $this->password = $password ?? null;
    $this->captchaToken = $captchaToken ?? null;

    parent::__construct();
  }


  /**
   *  Validate Data 
   * @return void
   */
  public function validateData() : void
  {
    //Validate email
    if (!is_null($this->email)) {
      if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
        self::$errors[] = "Invalid email";
      }
    } else {
      self::$errors[] = "Email required";
    }

    //Validate password
    if (is_null($this->password)) {
      self::$errors[] = "Password required";
    }

    //Validate recaptcha
    if (is_null($this->captchaToken)) {
      self::$errors[] = "Recaptcha token required";
    } else {
      $this->validateRecaptcha();
    }
  }

  /**
   * Validate Recaptcha token sended from client.
   * @return void
   */
  public function validateRecaptcha(): void
  {
    if (!ExternalApi::validateGoogleRecaptcha($this->captchaToken)) {
      self::$errors[] = "Invalid recaptcha!";
    }
  }

  /**
   * Get errors array
   * @return array
   */
  public function getErrors(): array
  {
    return parent::getErrors();
  }

  /**
   * Execute login in the application
   * @return bool
   */
  public function login(): bool
  {
    $response = false;

    try {

      parent::connectDB();

      $query = "SELECT id, name, lastname, email, password, id_role, (SELECT role FROM roles WHERE id = id_role) AS role FROM ";
      $query .= self::$tableName . " WHERE email = :email AND active = TRUE";

      $stmt = $this->dbConn->prepare($query);
      $stmt->bindParam(':email', $this->email, PDO::PARAM_STR, 255);
      $exec = $stmt->execute();

      if ($exec) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (is_array($user) && sizeof($user) > 0) {

          if (password_verify($this->password, $user['password'])) {

            session_start();

            $_SESSION['id_user'] = $user['id'];
            $_SESSION['name_user'] = $user['name'];
            $_SESSION['lastname_user'] = $user['lastname'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['id_role'] = $user['id_role'];
            $_SESSION['role'] = $user['role'];
            $response = true;
          }
        }
      }

      parent::closeConnDB();
      
    } catch (PDOException $e) {
      saveLog($e->getMessage(), Auth::class);
    }

    return $response;
  }


  public static function logout(): void
  {
    if (!isset($_SESSION)) {
      session_start();
    }

    if (isset($_SESSION['id_user'])) {
      session_destroy();
      header('Location: ./');
    }
  }
}
