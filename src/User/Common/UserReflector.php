<?php

declare(strict_types=1);

namespace App\User\Common;

use App\Common\Get\GetDTO;
use App\Common\Post\AddDTO;
use App\Common\Service\Reflector\ReflectorInterface;
use App\User\Get\UserGetDTO;
use App\User\Post\UserAddDTO;

final class UserReflector implements ReflectorInterface
{
    public const DEFAULT_PASSWORD = 'password';

    /**
     * @param UserGetDTO $dto
     * @return AddDTO
     */
    public function reflect(GetDTO $dto): UserAddDTO
    {
        return new UserAddDTO(
            name: $dto->name,
            email: $dto->email,
            group_id: $dto->group['id'] ?? [1],
            department: [1],
            password: self::DEFAULT_PASSWORD
        );
    }
}
