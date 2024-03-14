<?php

declare(strict_types=1);

namespace App\Manager\Factory;

use App\Manager\ImageManager;
use App\Repository\ImageRepository;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class ImageManagerFactory
{
    /**
     * @param ContainerInterface $container
     * @return ImageManager
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): ImageManager
    {
        $imageRepository = $container->get(ImageRepository::class);

        return new ImageManager($imageRepository);
    }
}
