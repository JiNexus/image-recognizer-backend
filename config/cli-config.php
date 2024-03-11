<?php

declare(strict_types=1);

use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Version\Comparator;
use Doctrine\Migrations\Version\Version;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

/** @var ContainerInterface $container */
$container = require 'config/container.php';

global $argv;
if (str_contains($argv[0], 'doctrine-migrations')) {
    try {
        /** @var DependencyFactory $factory */
        $factory = $container->get(DependencyFactory::class);
    } catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
        throw new Exception(
            $e->getMessage(),
            $e->getCode(),
            $e
        );
    }

    $factory->setService(Comparator::class, new class() implements Comparator {
        public function compare(Version $a, Version $b): int
        {
            return strcmp(self::versionWithoutNamespace($a), self::versionWithoutNamespace($b));
        }

        private static function versionWithoutNamespace(Version $version): string
        {
            $parsed = strrchr($version->__toString(), '\\');
            if ($parsed === false) {
                throw new \RuntimeException('Unable to parse version ' . $version->__toString());
            }

            return $parsed;
        }
    });

    return $factory;
}

try {
    /** @var EntityManager $entityManager */
    $entityManager = $container->get(EntityManager::class);
    return new SingleManagerProvider($entityManager);
} catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
    throw new Exception(
        $e->getMessage(),
        $e->getCode(),
        $e
    );
}
