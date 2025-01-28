<?php

declare(strict_types=1);

namespace App\Common\Get;

use RuntimeException;

abstract class GetDTO
{
    final public static function fromArray(array $data): self
    {
        throw new RuntimeException('Unimplemented');
    }

    final public function getId(): int
    {
        return $this->id;
    }

    final public function toArray(): array
    {
        return get_object_vars($this);
    }
}
