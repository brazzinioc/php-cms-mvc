<?php
declare(strict_types=1);

namespace Core;

use Exception;

class Router
{

  private $routesGET = [];
  private $routesPOST = [];

  /**
   * Registry all GET routes in $routesGET array
   * @param string $url
   * @param string $functionController  
   */
  public function get(string $url, array $functionController): void
  {
    $this->routesGET[$url] = $functionController;
  }

  /**
   * Registry all POST routes in $routesPOST array
   * @param string $url
   * @param string $functionController  
   */
  public function post(string $url, array $functionController): void
  {
    $this->routesPOST[$url] = $functionController;
  }

  /**
   * Get the Request URI and Method, after call function of Controller
   * @return void
   */
  public function verifyRoutes(): void
  {
    $currentUri = $_SERVER['REQUEST_URI'] ?? '/';
    $currentMethod = $_SERVER['REQUEST_METHOD'];

    if ($currentMethod === 'GET') {
      $functionController = $this->routesGET[$currentUri] ?? NULL; //Get function name of route, from routes array.
    } else {
      $functionController = $this->routesPOST[$currentUri] ?? NULL;
    }

    if ($functionController) {
      // $functionController is Namespace\Controller and $this is Router object ( executed whith call_user_func )
      call_user_func($functionController, $this);

    } else {
      
      $content = "<p style='font-size: 2rem; text-align:center; padding: 10rem 0;' class='text-indigo-500'>404 | ROUTE NOT FOUND</p>";
      
      include __DIR__ . '/../views/layout.php'; // $content is inject in layout.php
      exit;
    }

  }

  /**
   * Render a Views and send data
   * @param string $view
   * @param array $data
   * @return void
   */
  public function render(string $view, array $data = []): void
  {
    
    try {

      $view = __DIR__ . "/../views/$view.php";
      
      if (file_exists($view)) {

        if (sizeof($data) > 0) {
          foreach ($data as $key => $value) {
            $$key = $value;
          }
        }

        ob_start(); // start storage in memory

        include $view; // save view content in memory

        $content = ob_get_clean();  // clean buffer memory and save view content in $content variable.

      } else {
        $content = "<p style='font-size: 2rem; text-align:center; padding: 10rem 0;' class='text-indigo-500'>404 | VIEW NOT FOUND</p>";
      }

      include __DIR__ . '/../views/layout.php';  // $content is inject in layout.php
      exit;

    } catch (Exception $e) {
      saveLog($e->getMessage(), Router::class);
    }

  }
}
