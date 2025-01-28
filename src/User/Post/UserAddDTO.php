<?php

declare(strict_types=1);

namespace App\User\Post;

use App\Common\Post\AddDTO;

final class UserAddDTO extends AddDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public int $group_id,
        public array $department,
        public string $password,
    ) {}

    public function getUri(): string
    {
        return 'users/';
    }
}
