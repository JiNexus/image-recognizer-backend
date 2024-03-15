<?php

declare(strict_types=1);

use App\Collection\ImageCollection;
use Laminas\Hydrator\ObjectPropertyHydrator;
use Mezzio\Hal\Metadata\MetadataMap;
use App\Metadata\ImageMetadata;
use Mezzio\Hal\Metadata\RouteBasedCollectionMetadata;
use Mezzio\Hal\Metadata\RouteBasedResourceMetadata;

return [
    MetadataMap::class => [
        [
            '__class__' => RouteBasedResourceMetadata::class,
            'resource_class' => ImageMetadata::class,
            'route' => 'api.image-related',
            'extractor' => ObjectPropertyHydrator::class,
            'resource_identifier' => 'id',
        ],
        [
            '__class__' => RouteBasedCollectionMetadata::class,
            'collection_class' => ImageCollection::class,
            'collection_relation' => 'list-image-related',
            'route' => 'api.list-image-related',
        ],
    ],
];
