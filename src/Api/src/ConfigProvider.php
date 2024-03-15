<?php

declare(strict_types=1);

namespace Api;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'factories' => [
                Handler\ImageRelatedHandler::class => Handler\Factory\ImageRelatedHandlerFactory::class,
                Handler\ListImageRelatedHandler::class => Handler\Factory\ListImageRelatedHandlerFactory::class,
            ],
        ];
    }
}
