<?php

declare(strict_types=1);

namespace App\Repository\Factory;

use App\Repository\ImageLabelRepository;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class ImageLabelRepositoryFactory
{
    /**
     * @param ContainerInterface $container
     * @return ImageLabelRepository
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): ImageLabelRepository
    {
        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);

        return new ImageLabelRepository($entityManager);
    }
}
