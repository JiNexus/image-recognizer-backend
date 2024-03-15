<?php

declare(strict_types=1);

namespace Api\Handler;

use App\Manager\ImageManager;
use App\Metadata\ImageMetadata;
use Exception;
use Laminas\Hydrator\Strategy\HydratorStrategy;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use ReflectionException;

class ImageRelatedHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ImageManager $imageManager,
        private readonly HalResponseFactory $halResponseFactory,
        private readonly ResourceGenerator $resourceGenerator,
        private readonly HydratorStrategy $strategy
    ) { }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws ReflectionException
     * @throws Exception
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = $request->getAttribute('id', false);

        $image = $this->imageManager->getRepository()->find($id);
        /** @var ImageMetadata $imageMetadata */
        $imageMetadata = $this->strategy->hydrate($image->getArrayCopy());

        $uri = $request->getUri();
        $baseUrl = sprintf('%s://%s', $uri->getScheme(), $uri->getAuthority());

        $imageMetadata->id = $imageMetadata->id->toString();
        $imageMetadata->url = $baseUrl . '/asset/image/' . $imageMetadata->filename . '.' . $imageMetadata->fileExtension;

        if (! $imageMetadata instanceof ImageMetadata) {
            throw new Exception('Image with id `{$id}` not found');
        }

        $resource = $this->resourceGenerator->fromObject($imageMetadata, $request);
        return $this->halResponseFactory->createResponse($request, $resource);
    }
}
