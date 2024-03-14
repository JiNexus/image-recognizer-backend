<?php

declare(strict_types=1);

namespace App\Command\Factory;

use App\Command\ImportImageCommand;
use App\Manager\ImageImageLabelManager;
use App\Manager\ImageLabelManager;
use App\Manager\ImageManager;
use App\Service\Unsplash\UnsplashService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class ImportImageCommandFactory
{
    /**
     * @param ContainerInterface $container
     * @return ImportImageCommand
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): ImportImageCommand
    {
        $imageManager = $container->get(ImageManager::class);
        $imageLabelManager = $container->get(ImageLabelManager::class);
        $imageImageLabelManager = $container->get(ImageImageLabelManager::class);
        $unsplashService = $container->get(UnsplashService::class);

        return new ImportImageCommand(
            $imageManager,
            $imageLabelManager,
            $imageImageLabelManager,
            $unsplashService
        );
    }
}
