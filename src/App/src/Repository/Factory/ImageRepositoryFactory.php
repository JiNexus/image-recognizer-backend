<?php

declare(strict_types=1);

namespace App\Repository\Factory;

use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class ImageRepositoryFactory
{
    /**
     * @param ContainerInterface $container
     * @return ImageRepository
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): ImageRepository
    {
        /** @var EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);

        return new ImageRepository($entityManager);
    }
}
