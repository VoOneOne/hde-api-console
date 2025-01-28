<?php

declare(strict_types=1);

namespace App\User\Get;

use App\Common\Get\GetDTO;

final class UserGetDTO extends GetDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public ?array $department = null,
        public ?array $group = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            name: $data['name'] ?? null,
            email: $data['email'] ?? null,
            department: $data['department'] ?? null,
            group: $data['group'] ?? null,
        );
    }
}
