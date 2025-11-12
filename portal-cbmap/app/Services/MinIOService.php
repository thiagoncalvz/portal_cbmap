<?php

namespace App\Services;

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

class MinIOService
{
    protected $client;

    public function __construct()
    {
        $this->client = new S3Client([
            'version' => 'latest',
            'region'  => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'endpoint' => env('MINIO_ENDPOINT'),
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key'    => env('MINIO_ACCESS_KEY'),
                'secret' => env('MINIO_SECRET_KEY'),
            ],
        ]);
    }

    public function upload($bucket, $key, $filePath, $contentType = 'application/pdf')
    {
        try {
            $result = $this->client->putObject([
                'Bucket'      => $bucket,
                'Key'         => $key,
                'SourceFile'  => $filePath,
                'ACL'         => 'private',
                'ContentType' => $contentType,
            ]);

            return [
                'success' => true,
                'url' => $result['ObjectURL'] ?? null,
            ];
        } catch (AwsException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    public function delete(string $bucket, string $key): array
    {
        try {
            $this->client->deleteObject([
                'Bucket' => $bucket,
                'Key'    => $key,
            ]);

            return ['success' => true];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'error'   => $e->getMessage(),
            ];
        }
    }

    public function getObject(string $bucket, string $key)
    {
        try {
            $result = $this->client->getObject([
                'Bucket' => $bucket,
                'Key'    => $key,
            ]);

            return [
                'success' => true,
                'body'    => $result['Body'],              // stream
                'type'    => $result['ContentType'] ?? 'application/octet-stream',
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'error'   => $e->getMessage(),
            ];
        }
    }
}
