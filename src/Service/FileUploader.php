<?php

namespace App\Service;

use App\Entity\Noticia;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function upload(UploadedFile $file, Noticia $noticia)
    {
        try {
            $path = rtrim($_ENV['data_dir'], "/").'/noticias/archivos';
            $noticia->setPath($path);
            $noticia->setFile($file);
            return $noticia;
        } catch (FileException $e){
            $this->logger->error('failed to upload image: ' . $e->getMessage());
            throw new FileException('Failed to upload file');
        }
    }
}