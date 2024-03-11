<?php

declare(strict_types=1);

namespace App\Entity\Trait;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Mapping as ORM;

trait UpdatedAtTimestampTrait
{
    #[ORM\Column(name: 'updated_at', type: Types::DATETIME_MUTABLE)]
    private DateTime $updatedAt;

    /**
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param PrePersistEventArgs|PreUpdateEventArgs $args
     * @return $this
     */
    #[ORM\PrePersist, ORM\PreUpdate]
    public function setUpdatedAt(PrePersistEventArgs | PreUpdateEventArgs  $args): static
    {
        $this->updatedAt = new DateTime();

        return $this;
    }
}
