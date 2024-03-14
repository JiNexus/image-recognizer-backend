<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Trait\CreatedAtTimestampTrait;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Table(name: '`image_image_label`')]
#[ORM\UniqueConstraint(columns: ['image_id', 'image_label_id'])]
class ImageImageLabel
{
    use CreatedAtTimestampTrait;

    #[ORM\Id]
    #[ORM\Column(name: 'id', type: 'uuid')]
    #[ORM\GeneratedValue(strategy: 'NONE')]
    private UuidInterface $id;

    #[ORM\ManyToOne(targetEntity: Image::class)]
    #[ORM\JoinColumn(name: 'image_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private Image $image;

    #[ORM\ManyToOne(targetEntity: ImageLabel::class)]
    #[ORM\JoinColumn(name: 'image_label_id', referencedColumnName: 'id', onDelete: 'CASCADE')]
    private ImageLabel $imageLabel;

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
        ! empty($data['image']) ? $this->setImage($data['image']) : $this->setImage();
        ! empty($data['imageLabel']) ? $this->setImageLabel($data['imageLabel']) : $this->setImageLabel();
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
     * @return Image
     */
    public function getImage(): Image
    {
        return $this->image;
    }

    /**
     * @param Image|null $image
     * @return $this
     */
    public function setImage(Image $image = null): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return ImageLabel
     */
    public function getImageLabel(): ImageLabel
    {
        return $this->imageLabel;
    }

    /**
     * @param ImageLabel|null $imageLabel
     * @return $this
     */
    public function setImageLabel(ImageLabel $imageLabel = null): self
    {
        $this->imageLabel = $imageLabel;

        return $this;
    }
}
