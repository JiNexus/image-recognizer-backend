<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\Image;
use App\Repository\ImageRepository;
use Exception;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use League\Flysystem\Local\LocalFilesystemAdapter;

class ImageManager
{
    /**
     * @param ImageRepository $imageRepository
     */
    public function __construct(
        private readonly ImageRepository $imageRepository
    ) { }

    /**
     * @return ImageRepository
     */
    public function getRepository(): ImageRepository
    {
        return $this->imageRepository;
    }

    /**
     * @param array $data
     * @return Image
     * @throws Exception
     */
    public function createImage(array $data = []): Image
    {
        if (! $data) {
            throw new Exception('Data is empty');
        }

        $image = new Image();
        $image->setFilename($data['filename']);
        $image->setFileExtension($data['fileExtension']);
        $image->setSlug($data['slug']);
        $image->setDescription($data['description']);

        return $this->imageRepository->persist($image);
    }

    /**
     * @param $url
     * @param $filename
     * @return void
     * @throws FilesystemException
     */
    public function saveToLocal($url, $filename): void
    {
        $adapter = new LocalFilesystemAdapter(LOCAL_STORAGE_IMAGE);
        $filesystem = new Filesystem($adapter);

        // Download the image from the URL
        $imageContents = file_get_contents($url);

        if ($imageContents !== false) {
            // Write the image contents to the destination file using Flysystem
            $filesystem->write($filename, $imageContents);
        }
    }
}
