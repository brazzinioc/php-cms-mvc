<?php

declare(strict_types=1);

namespace Controllers;

use Core\Router;
use Exception;
use Models\Auth;


class AuthController
{

  public static function login(Router $router): void
  {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      $errors = [];
      $router->render('auth/login', $errors);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $auth = new Auth($_POST['email'], $_POST['password'], $_POST['g-recaptcha-response']);
      $auth->validateData();
      $errors = $auth->getErrors();

      if (empty($errors)) {
        if ($auth->login()) {
          $router->render('auth/login', ["errors" => "Access is correct"]);
        } else {
          $router->render('auth/login', ["errors" => ["Password and Email is incorrect."]]);
        }
      } else {
        $router->render('auth/login', ["errors" => $errors]);
      }
    }
  }


  public static function logout(Router $router): void
  {
    try {

      validateStartSession();
      session_destroy();

      header('Location: ./');

    } catch (Exception $e) {
      saveLog($e->getMessage(), AuthController::class);
    }
  }
}
