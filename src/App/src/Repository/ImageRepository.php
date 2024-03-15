<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Image;
use App\Entity\ImageImageLabel;
use App\Entity\ImageLabel;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ObjectRepository;

final class ImageRepository implements ObjectRepository
{
    private EntityRepository $repository;

    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
        $this->repository = $this->entityManager->getRepository(Image::class);
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }

    public function findBy(
        array $criteria,
        ?array $orderBy = null,
        ?int $limit = null,
        ?int $offset = null
    ): array {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    public function findOneBy(array $criteria, array $orderBy = null): Image|null
    {
        return $this->repository->findOneBy($criteria, $orderBy);
    }

    public function getClassName(): string
    {
        return self::class;
    }

    public function persist(Image $image): Image
    {
        $this->entityManager->persist($image);
        $this->entityManager->flush();

        return $image;
    }

    public function remove(Image $image): Image
    {
        $this->entityManager->remove($image);
        $this->entityManager->flush();

        return $image;
    }

    /**
     * @param array $labels
     * @return Query
     */
    public function findRelatedImages(array $labels = []): Query
    {
        $queryBuilder = $this->repository->createQueryBuilder('i');
        return $queryBuilder->select('
            i.id AS id,
            i.filename AS filename,
            i.fileExtension AS fileExtension,
            i.slug AS slug,
            i.description AS description,
            il.name AS label,
            i.createdAt AS createdAt,
            i.updatedAt AS updatedAt
        ')
            ->innerJoin(ImageImageLabel::class, 'iil', JOIN::WITH, 'i.id = iil.image')
            ->innerJoin(ImageLabel::class, 'il', JOIN::WITH, 'iil.imageLabel = il.id')
            ->where($queryBuilder->expr()->in('il.name', $labels))
            ->getQuery();
    }
}
