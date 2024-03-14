<?php

declare(strict_types=1);

namespace App\Service\Unsplash\Factory;

use App\Service\Unsplash\UnsplashService;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class UnsplashServiceFactory
{
    /**
     * @param ContainerInterface $container
     * @return UnsplashService
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): UnsplashService
    {
        $config = $this->getConfig($container);

        return new UnsplashService($config);
    }

    /**
     * @param ContainerInterface $container
     * @return mixed
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    private function getConfig(ContainerInterface $container): mixed
    {
        $config = $container->get('config');

        if (isset($config['unsplash'])) {
            return $config['unsplash'];
        }

        return [];
    }
}
