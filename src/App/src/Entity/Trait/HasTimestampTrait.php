<?php

declare(strict_types=1);

namespace App\Entity\Trait;

trait HasTimestampTrait
{
    use CreatedAtTimestampTrait, UpdatedAtTimestampTrait;
}
