<?php

declare(strict_types=1);

namespace App;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.laminas.dev/laminas-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'laminas-cli' => $this->getLaminasCli(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'invokables' => [
                Handler\PingHandler::class => Handler\PingHandler::class,
            ],
            'factories'  => [
                Command\FixtureCommand::class => Command\Factory\FixtureCommandFactory::class,
                Command\ImportImageCommand::class => Command\Factory\ImportImageCommandFactory::class,
                Handler\HomePageHandler::class => Handler\Factory\HomePageHandlerFactory::class,
                Manager\ImageManager::class => Manager\Factory\ImageManagerFactory::class,
                Manager\ImageLabelManager::class => Manager\Factory\ImageLabelManagerFactory::class,
                Manager\ImageImageLabelManager::class => Manager\Factory\ImageImageLabelManagerFactory::class,
                Repository\ImageRepository::class => Repository\Factory\ImageRepositoryFactory::class,
                Repository\ImageLabelRepository::class => Repository\Factory\ImageLabelRepositoryFactory::class,
                Repository\ImageImageLabelRepository::class => Repository\Factory\ImageImageLabelRepositoryFactory::class,
                Service\Unsplash\UnsplashService::class => Service\Unsplash\Factory\UnsplashServiceFactory::class,
            ],
        ];
    }

    /**
     * @return array[]
     */
    public function getLaminasCli(): array
    {
        return [
            'commands' => [
                'data-fixtures:load' => Command\FixtureCommand::class,
                'data-image-import:load' => Command\ImportImageCommand::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [
                'app'    => [__DIR__ . '/../templates/app'],
                'error'  => [__DIR__ . '/../templates/error'],
                'layout' => [__DIR__ . '/../templates/layout'],
            ],
        ];
    }
}
