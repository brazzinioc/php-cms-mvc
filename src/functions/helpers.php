<?php

if (!function_exists('loadEnvVariables')) {

  function loadEnvVariables(): void
  {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../"); # Read .env file.
    $dotenv->load();

    // DB
    define('DB_USER', $_ENV['DB_USER']);
    define('DB_PASSWORD', $_ENV['DB_PASSWORD']);
    define('DB_NAME', $_ENV['DB_NAME']);
    define('DB_DRIVER', $_ENV['DB_DRIVER']);
    define('DB_HOSTNAME', $_ENV['DB_HOST']);
    define('DB_PORT', $_ENV['DB_PORT']);

    // Recaptcha v3
    define('RECAPTCHA_BASE_URL', $_ENV['RECAPTCHA_BASE_URL']);
    define('RECAPTCHA_VERIFY_API', $_ENV['RECAPTCHA_VERIFY_API']);
    define('RECAPTCHA_PUBLIC_KEY', $_ENV['RECAPTCHA_PUBLIC_KEY']);
    define('RECAPTCHA_SECRET_TOKEN', $_ENV['RECAPTCHA_SECRET_TOKEN']);

    // AWS S3 Storage
    define('S3_BUCKET_NAME', $_ENV['S3_BUCKET_NAME']);
    define('S3_BUCKET_REGION', $_ENV['S3_BUCKET_REGION']);
    define('S3_ACCESS_KEY_ID', $_ENV['S3_ACCESS_KEY_ID']);
    define('S3_SECRET_ACCESS_KEY', $_ENV['S3_SECRET_ACCESS_KEY']);

    // DOMAIN APP
    define('DOMAIN_APP', $_ENV['DOMAIN_APP']);
  }
}


if (!function_exists('saveLog')) {
  //Save error_logs in Log File
  function saveLog($errorLog, $fileSource): void
  {
    try {

      $currentDate = Date('Y-m-d');
      $pathLogDir = __DIR__ . "/../logs";
      $pathLogFile = "{$pathLogDir}/{$currentDate}.log";

      //create directory
      if (!file_exists($pathLogDir)) {
        mkdir($pathLogDir, 0700, true);
      }

      //create log file
      if (!file_exists($pathLogFile)) {
        fopen($pathLogFile, "w");
      }

      //write error log
      if (file_exists($pathLogFile)) {
        $currentHour = Date('h:i:s');
        error_log("{$currentHour} | {$fileSource} | Error Log: " . print_r($errorLog, true) . "\n\n", 3, $pathLogFile);
      }
    } catch (Exception $e) {
      error_log($e->getMessage());
    }
  }
}

if (!function_exists('sanitize')) {
  //Sanitize HTML
  function sanitize(string $html): string
  {
    return htmlspecialchars($html);
  }
}


if (!function_exists('generateUniqueRandomString')) {
  function generateUniqueRandomString(): string
  {
    $randomString = md5(uniqid(rand(), true));
    return $randomString;
  }
}

if (!function_exists('validateStartSession')) {
  function validateStartSession()
  {
    if (!isset($_SESSION) && empty($_SESSION)) {
      session_start();
    }
  }
}


if (!function_exists('showBeatifulDate')) {
  function showBeautifulDate(string $date): string
  {
    $beatifulDate = '';

    if (isset($date)) $beatifulDate = strftime('%A, %d of %B %Y', strtotime($date));

    return $beatifulDate;
  }
}



if (!function_exists('showBreadcrumbs')) {
  function showBreadcrumbs(): array
  {
    $result = [];
    $uriPath = $_SERVER["REQUEST_URI"];

    if (isset($uriPath)) {
      $result = explode("/", $uriPath);
    }

    return $result;
  }
}


if (!function_exists('showMessage')) {
  function showMessage(int $messageId): string
  {
    $message = '';

    if (isset($messageId)) {

      switch ($messageId) {
        case 1:
          $message = "Created successfully.";
          break;

        case 2:
          $message = "Updated successfully.";
          break;

        case 3:
          $message = "Deleted successfully.";
          break;

        default:
          $message  = "Unexpected error, try again later.";
          break;
      }
    }

    return $message;
  }
}


if (!function_exists('debugg')) {
  function debugg($data): void
  {
    echo "<pre>";
      var_dump($data);
    echo "</pre>";
    exit();
  }
}
