<?php

declare(strict_types=1);

namespace Api\Handler;

use App\Collection\ImageCollection;
use App\Manager\ImageManager;
use App\Metadata\ImageMetadata;
use Laminas\Hydrator\Strategy\CollectionStrategy;
use Laminas\Paginator\Adapter\ArrayAdapter;
use Mezzio\Hal\HalResponseFactory;
use Mezzio\Hal\ResourceGenerator;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ListImageRelatedHandler implements RequestHandlerInterface
{
    public function __construct(
        private readonly ImageManager $imageManager,
        private readonly HalResponseFactory $halResponseFactory,
        private readonly ResourceGenerator $resourceGenerator,
        private readonly CollectionStrategy $strategy,
    ) { }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $queryParams = $request->getQueryParams();

        $all = isset($queryParams['all']);
        $labels = explode(',', $queryParams['labels']);
        $page = $queryParams['page'] ?? 1;
        $perPage = $queryParams['perPage'] ?? 25;

        $imagesQuery = $this->imageManager->getRepository()->findRelatedImages($labels);
        $imageMetadataCollections = $this->strategy->hydrate($imagesQuery->getArrayResult());

        $uri = $request->getUri();
        $baseUrl = sprintf('%s://%s', $uri->getScheme(), $uri->getAuthority());

        $result = array_map(function ($image) use ($baseUrl) {
            /** @var  ImageMetadata $image */
            $image->id = $image->id->toString();
            $image->url = $baseUrl . '/asset/image/' . $image->filename . '.' . $image->fileExtension;
            return $image;
        }, $imageMetadataCollections);

        $adapter = new ArrayAdapter($result);
        $imagesPaginator = new ImageCollection($adapter);
        $imagesPaginator->setItemCountPerPage($all ? $imagesPaginator->getTotalItemCount() : $perPage);
        $imagesPaginator->setCurrentPageNumber($page);

        $resource = $this->resourceGenerator->fromObject($imagesPaginator, $request);
        return $this->halResponseFactory->createResponse($request, $resource);
    }
}
