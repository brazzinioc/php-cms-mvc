<?php

declare(strict_types=1);

namespace Config;

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;


class Storage
{

  private static $s3BucketName = S3_BUCKET_NAME ?? null;
  private static $s3BucketRegion = S3_BUCKET_REGION ?? null;
  private static $s3AccessKeyId = S3_ACCESS_KEY_ID ?? null;
  private static $s3SecretAccessKey = S3_SECRET_ACCESS_KEY ?? null;
  private static $s3Client = null;

  private static function createS3Client(): void
  {

    if (!is_null(self::$s3BucketName) && !is_null(self::$s3BucketRegion) && !is_null(self::$s3AccessKeyId) && !is_null(self::$s3SecretAccessKey)) {

      self::$s3Client = new S3Client([
        'version'     => 'latest',
        'region'      => self::$s3BucketRegion,
        'credentials' => [
          'key'    => self::$s3AccessKeyId,
          'secret' => self::$s3SecretAccessKey,
        ],
      ]);
    }
  }

  public static function save(string $storageType, string $directoryFileName, string $file): bool
  {

    $result = false;

    if ($storageType == 'S3') {

      self::createS3Client();

      if (!is_null(self::$s3Client) && !empty($directoryFileName) && !empty($file)) {

        try {

          $result = self::$s3Client->putObject([
            'Bucket' => self::$s3BucketName,
            'Key' => $directoryFileName,
            'SourceFile' => $file,
          ]);

          $result = true;
        } catch (S3Exception $e) {
          saveLog($e->getMessage(), Storage::class);
        }
      }
    } else {
    }

    return $result;
  }
}
