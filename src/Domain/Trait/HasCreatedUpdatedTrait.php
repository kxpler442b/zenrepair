<?php

declare(strict_types = 1);

namespace App\Domain\Trait;

use Carbon\Carbon;
use Doctrine\ORM\Mapping\Column;

/**
 * Used to store the Created and Updated value for an entity.
 */
trait HasCreatedUpdatedTrait
{
    #[Column(type: 'carbon', updatable: false)]
    private Carbon $created;

    #[Column(type: 'carbon')]
    private Carbon $updated;

    // Retrieve the $created value.
    public function getCreated(): Carbon
    {
        return $this->created;
    }

    // Store a $created value.
    // NB: This can only be issued once per entity.
    public function setCreated(Carbon $created): self
    {
        $this->created = $created;

        return $this;
    }

    // Retrieve the $updated value.
    public function getUpdated(): Carbon
    {
        return $this->updated;
    }

    // Store an $updated value.
    public function setUpdated(Carbon $updated): self
    {
        $this->updated = $updated;

        return $this;
    }
}