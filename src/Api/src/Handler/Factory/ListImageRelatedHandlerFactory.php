<?php

declare(strict_types=1);

namespace Api\Handler\Factory;

use Api\Handler\ListImageRelatedHandler;
use App\Manager\ImageManager;
use App\Metadata\ImageMetadata;
use Laminas\Hydrator\ObjectPropertyHydrator;
use Laminas\Hydrator\Strategy\CollectionStrategy;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ListImageRelatedHandlerFactory
{
    /**
     * @param ContainerInterface $container
     * @return RequestHandlerInterface
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $container): RequestHandlerInterface
    {
        $imageManager = $container->get(ImageManager::class);
        $halResponseFactory = $container->get(HalResponseFactory::class);
        $resourceGenerator = $container->get(ResourceGenerator::class);
        $strategy = $this->getStrategy(ImageMetadata::class);

        return new ListImageRelatedHandler($imageManager, $halResponseFactory, $resourceGenerator, $strategy);
    }

    public function getStrategy(string $class): CollectionStrategy
    {
        return new CollectionStrategy(
            new ObjectPropertyHydrator(),
            $class
        );
    }
}
