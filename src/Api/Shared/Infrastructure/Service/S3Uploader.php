<?php

namespace App\Api\Shared\Infrastructure\Service;

use Aws\S3\S3Client;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class S3Uploader
{
    private S3Client $s3Client;
    private string $bucket;

    public function __construct(string $awsKey, string $awsSecret, string $awsRegion, string $bucket)
    {
        $this->s3Client = new S3Client([
            'version' => 'latest',
            'region' => $awsRegion,
            'credentials' => [
                'key' => $awsKey,
                'secret' => $awsSecret,
            ],
        ]);
        $this->bucket = $bucket;
    }

    /**
     * @throws \Exception
     */
    public function upload(UploadedFile $file, string $folder): string
    {
        $fileName = uniqid() . '_' . $file->getClientOriginalName();
        $fileKey = $folder . $fileName;

        try {
            $result = $this->s3Client->putObject([
                'Bucket' => $this->bucket,
                'Key' => $fileKey,
                'SourceFile' => $file->getRealPath(),
            ]);

            return $result['ObjectURL'];
        } catch (\Exception $e) {
            throw new \Exception('Error al subir el archivo a S3: ' . $e->getMessage());
        }
    }
}