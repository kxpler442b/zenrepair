<?php

declare(strict_types = 1);

namespace App\Domain\Trait;

use DateTime;
use Doctrine\ORM\Mapping\Column;

trait CreatedUpdatedTrait
{
    #[Column(type: 'datetime', updatable: false)]
    private DateTime $created;

    #[Column(type: 'datetime')]
    private DateTime $updated;

    public function getCreated(): DateTime
    {
        return $this->created;
    }

    public function setCreated(): self
    {
        $this->created = new DateTime('now');

        return $this;
    }

    public function getUpdated(): DateTime
    {
        return $this->updated;
    }

    public function setUpdated(): self
    {
        $this->updated = new DateTime('now');

        return $this;
    }
}