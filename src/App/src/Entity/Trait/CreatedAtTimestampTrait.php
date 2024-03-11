<?php

declare(strict_types=1);

namespace App\Entity\Trait;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Event\PrePersistEventArgs ;
use Doctrine\ORM\Mapping as ORM;

trait CreatedAtTimestampTrait
{
    #[ORM\Column(name: 'created_at', type: Types::DATETIME_MUTABLE)]
    private DateTime $createdAt;

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param PrePersistEventArgs $args
     * @return $this
     */
    #[ORM\PrePersist]
    public function setCreatedAt(PrePersistEventArgs $args): static
    {
        if (! isset($this->createdAt)) {
            $this->createdAt = new DateTime();
        }

        return $this;
    }
}
