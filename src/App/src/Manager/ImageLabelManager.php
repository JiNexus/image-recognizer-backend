<?php

declare(strict_types=1);

namespace App\Manager;

use App\Repository\ImageLabelRepository;

class ImageLabelManager
{
    /**
     * @param ImageLabelRepository $imageLabelRepository
     */
    public function __construct(
        private readonly ImageLabelRepository $imageLabelRepository
    ) { }

    /**
     * @return ImageLabelRepository
     */
    public function getRepository(): ImageLabelRepository
    {
        return $this->imageLabelRepository;
    }
}
