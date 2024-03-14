<?php

declare(strict_types=1);

namespace App\Manager;

use App\Entity\ImageImageLabel;
use App\Repository\ImageImageLabelRepository;
use Exception;

class ImageImageLabelManager
{
    /**
     * @param ImageImageLabelRepository $imageImageLabelRepository
     */
    public function __construct(
        private readonly ImageImageLabelRepository $imageImageLabelRepository
    ) { }

    /**
     * @return ImageImageLabelRepository
     */
    public function getRepository(): ImageImageLabelRepository
    {
        return $this->imageImageLabelRepository;
    }

    /**
     * @param array $data
     * @return ImageImageLabel
     * @throws Exception
     */
    public function createImageImageLabel(array $data = []): ImageImageLabel
    {
        if (! $data) {
            throw new Exception('Data is empty');
        }

        $imageImageLabel = new ImageImageLabel([
            'image' => $data['image'],
            'imageLabel' => $data['imageLabel'],
        ]);

        return $this->imageImageLabelRepository->persist($imageImageLabel);
    }
}
