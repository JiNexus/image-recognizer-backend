<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\HasTimestampTrait;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: '`image`')]
class Image
{
    use HasTimestampTrait;

    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'uuid')]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    private UuidInterface $id;

    #[ORM\Column(name: 'filename', type: Types::STRING, length: 255)]
    private string $filename;

    #[ORM\Column(name: 'file_extension', type: Types::STRING, length: 255)]
    private string $fileExtension;

    #[ORM\Column(name: 'slug', type: Types::STRING, length: 255)]
    private string $slug;

    #[ORM\Column(name: 'description', type: Types::TEXT, nullable: true)]
    private ?string $description;

    /**
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->exchangeArray($data);
    }

    /**
     * @param array $data
     * @return void
     */
    public function exchangeArray(array $data = []): void
    {
        ! empty($data['id']) ? $this->setId($data['id']) : $this->setId();
        ! empty($data['filename']) ? $this->setFilename($data['filename']) : $this->setFilename();
        ! empty($data['fileExtension']) ? $this->setFileExtension($data['fileExtension']) : $this->setFileExtension();
        ! empty($data['slug']) ? $this->setSlug($data['slug']) : $this->setSlug();
        ! empty($data['description']) ? $this->setDescription($data['description']) : $this->setDescription();
    }

    /**
     * @return array
     */
    public function getArrayCopy(): array
    {
        return get_object_vars($this);
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @param UuidInterface|null $id
     * @return $this
     */
    public function setId(UuidInterface $id = null): self
    {
        $this->id = $id ?: Uuid::uuid4();

        return $this;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     * @return $this
     */
    public function setFilename(string $filename = ''): self
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @return string
     */
    public function getFileExtension(): string
    {
        return $this->fileExtension;
    }

    /**
     * @param string $fileExtension
     * @return $this
     */
    public function setFileExtension(string $fileExtension = ''): self
    {
        $this->fileExtension = $fileExtension;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return $this
     */
    public function setSlug(string $slug = ''): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return $this
     */
    public function setDescription(?string $description = null): self
    {
        $this->description = $description;

        return $this;
    }
}
