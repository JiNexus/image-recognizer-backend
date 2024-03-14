<?php

declare(strict_types=1);

namespace App\Manager\Factory;

use App\Manager\ImageLabelManager;
use App\Repository\ImageLabelRepository;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class ImageLabelManagerFactory
{
    /**
     * @param ContainerInterface $container
     * @return ImageLabelManager
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): ImageLabelManager
    {
        $imageLabelRepository = $container->get(ImageLabelRepository::class);

        return new ImageLabelManager($imageLabelRepository);
    }
}
