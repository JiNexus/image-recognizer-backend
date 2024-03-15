<?php

declare(strict_types=1);

namespace App\Metadata;

use DateTime;
use Ramsey\Uuid\UuidInterface;

class ImageMetadata
{
    public UuidInterface|string $id;

    public string $filename;

    public string $fileExtension;

    public string $slug;

    public ?string $description;

    public string $label;

    public string $url;

    public DateTime $createdAt;

    public DateTime $updatedAt;

    public static function create(
        UuidInterface|string $id,
        string $filename,
        string $fileExtension,
        string $slug,
        ?string $description,
        string $label,
        string $url,
        DateTime $createdAt,
        DateTime $updatedAt
    ) : ImageMetadata
    {
        $image = new self();
        $image->exchangeArray([
            'id' => $id,
            'filename' => $filename,
            'fileExtension' => $fileExtension,
            'slug' => $slug,
            'description' => $description,
            'label' => $label,
            'url' => $url,
            'createdAt' => $createdAt,
            'updatedAt' => $updatedAt,
        ]);

        return $image;
    }

    public function exchangeArray(array $image) : void
    {
        $this->id = $image['id'] ?? 0;
        $this->filename = $image['filename'];
        $this->fileExtension = $image['fileExtension'] ?? '';
        $this->slug = $image['slug'] ?? '';
        $this->description = $image['description'] ?? '';
        $this->label = $image['label'] ?? '';
        $this->url = $image['url'] ?? '';
        $this->createdAt = $image['createdAt'] ?? '';
        $this->updatedAt = $image['updatedAt'] ?? '';
    }

    public function getArrayCopy(): array
    {
        return get_object_vars($this);
    }
}
