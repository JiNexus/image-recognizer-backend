<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ImageImageLabel;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\Persistence\ObjectRepository;

final class ImageImageLabelRepository implements ObjectRepository
{
    /**
     * @var EntityRepository
     */
    private EntityRepository $repository;

    public function __construct(
        private readonly EntityManagerInterface $entityManager
    )
    {
        $this->repository = $this->entityManager->getRepository(ImageImageLabel::class);
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
    ): array
    {
        return $this->repository->findBy($criteria, $orderBy, $limit, $offset);
    }

    public function findOneBy(array $criteria, array $orderBy = null): ImageImageLabel|null
    {
        return $this->repository->findOneBy($criteria);
    }

    public function getClassName(): string
    {
        return self::class;
    }

    public function persist(ImageImageLabel $imageImageLabel): ImageImageLabel
    {
        $this->entityManager->persist($imageImageLabel);
        $this->entityManager->flush();

        return $imageImageLabel;
    }

    public function remove(ImageImageLabel $imageImageLabel): ImageImageLabel
    {
        $this->entityManager->remove($imageImageLabel);
        $this->entityManager->flush();

        return $imageImageLabel;
    }
}
