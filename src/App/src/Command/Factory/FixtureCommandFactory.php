<?php

declare(strict_types=1);

namespace App\Command\Factory;

use App\Command\FixtureCommand;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class FixtureCommandFactory
{
    /**
     * @param ContainerInterface $container
     * @return FixtureCommand
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): FixtureCommand
    {
        $config = $this->getConfig($container);
        $entityManager = $container->get(EntityManager::class);

        return new FixtureCommand($config, $entityManager);
    }

    /**
     * @param ContainerInterface $container
     * @return array
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    protected function getConfig(ContainerInterface $container): array
    {
        $config = $container->get('config');
        if (isset($config['doctrine']['fixtures'])) {
            return $config['doctrine']['fixtures'];
        }

        return [];
    }
}
