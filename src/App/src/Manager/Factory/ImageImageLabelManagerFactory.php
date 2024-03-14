<?php

declare(strict_types=1);

namespace App\Manager\Factory;

use App\Manager\ImageImageLabelManager;
use App\Repository\ImageImageLabelRepository;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class ImageImageLabelManagerFactory
{
    /**
     * @param ContainerInterface $container
     * @return ImageImageLabelManager
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): ImageImageLabelManager
    {
        $imageImageLabelRepository = $container->get(ImageImageLabelRepository::class);

        return new ImageImageLabelManager($imageImageLabelRepository);
    }
}
