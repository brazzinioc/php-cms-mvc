<?php 
declare(strict_types=1);

include(__DIR__ . '/../vendor/autoload.php');
loadEnvVariables();


use Core\Router;
use Controllers\AuthController;

$router = new Router();

/********************************* 
 * DEFINE ROUTES
*********************************/

//Loging and Logout routes
$router->get('/login', [ AuthController::class, 'login' ]);
$router->post('/login', [ AuthController::class, 'login' ]);
$router->get('/logout', [ AuthController::class, 'logout' ]);

/*
*
* Add your routes here
*
*/



$router->verifyRoutes();


?>