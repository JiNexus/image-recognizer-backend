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
#[ORM\Table(name: '`image_label`')]
class ImageLabel
{
    use HasTimestampTrait;

    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'uuid')]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    private UuidInterface $id;

    #[ORM\Column(name: 'name', type: Types::STRING, length: 255)]
    private string $name;

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
        ! empty($data['name']) ? $this->setName($data['name']) : $this->setName();
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name = ''): self
    {
        $this->name = $name;

        return $this;
    }
}
