<?php
declare(strict_types=1);

namespace Models;

use Exception;
use GuzzleHttp\Client;

class ExternalApi
{

  /**
   * Verify and validate the google recaptcha token sended from client.
   * @var $captchaToken
   * @return bool
   */
  public static function validateGoogleRecaptcha(string $captchaToken): bool
  {
    $result = FALSE;

    if (isset($captchaToken)) {
      try {

        $client = new Client([
          'base_uri' => RECAPTCHA_BASE_URL,
          'timeout'  => 2.0,
        ]);

        // send token to google recaptcha v3 api
        $apiResponse = $client->request('POST', RECAPTCHA_VERIFY_API, [
          'form_params' => [
            'secret' => RECAPTCHA_SECRET_TOKEN,
            'response' => $captchaToken
          ]
        ]);

        if (intval($apiResponse->getStatusCode()) == 200) {
          
          $response = strval($apiResponse->getBody());

          if (strlen($response)) {
          
            $response = json_decode($response, true); //convert json to array assocc
          
            if ($response['success']) {
              $result = TRUE;
            }
            
          }
        }
      } catch (Exception $e) {
        saveLog($e->getMessage(), ExternalApi::class);
      }
    }

    return $result;
  }

}
