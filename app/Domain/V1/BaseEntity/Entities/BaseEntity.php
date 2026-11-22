<?php

namespace App\Domain\V1\BaseEntity\Entities;

abstract class BaseEntity
{
    protected ?bool $active = null;

    public function active(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }
}
