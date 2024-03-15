<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ImageImageLabel;
use App\Entity\ImageLabel;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\Persistence\ObjectRepository;

final class ImageLabelRepository implements ObjectRepository
{
    private EntityRepository $repository;

    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {
        $this->repository = $this->entityManager->getRepository(ImageLabel::class);
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

    public function findOneBy(array $criteria, array $orderBy = null): ImageLabel|null
    {
        return $this->repository->findOneBy($criteria, $orderBy);
    }

    public function getClassName(): string
    {
        return self::class;
    }

    public function findImageLabelWithNoAssociatedImage()
    {
        $queryBuilder = $this->repository->createQueryBuilder('il');
        $query = $queryBuilder->select('
                    il.id AS il_id,
                    il.name AS il_name,
                    il.createdAt AS il_createdAt,
                    il.updatedAt AS il_updatedAt
                ')
            ->leftJoin(ImageImageLabel::class, 'iil', Join::WITH, 'il.id = iil.imageLabel')
            ->where('iil.image IS NULL')
            ->orderBy('il.name', 'ASC')
            ->getQuery();

        return $query->getResult();
    }

    public function persist(ImageLabel $imageLabel): ImageLabel
    {
        $this->entityManager->persist($imageLabel);
        $this->entityManager->flush();

        return $imageLabel;
    }

    public function remove(ImageLabel $imageLabel): ImageLabel
    {
        $this->entityManager->remove($imageLabel);
        $this->entityManager->flush();

        return $imageLabel;
    }
}
