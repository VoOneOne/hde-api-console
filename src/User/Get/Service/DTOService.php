<?php

declare(strict_types=1);

namespace App\User\Get\Service;

use App\User\Get\UserGetDTO;
use App\User\Post\UserAddDTO;

final class DTOService
{
    public static function createAddUserDTO(UserGetDTO $getUserDTO, string $password): UserAddDTO
    {
        return new UserAddDTO(
            name: $getUserDTO->name,
            email: $getUserDTO->email,
            group_id: $getUserDTO->group['id'],
            department: $getUserDTO->department ?? [],
            password: $password,
            lastname: $getUserDTO->lastname ?: null,
            alias: $getUserDTO->alias ?: null,
            phone: $getUserDTO->phone ?: null,
            skype: $getUserDTO->skype ?: null,
            website: $getUserDTO->website ?: null,
            organization: $getUserDTO->organization['name'] ?? null,
            organiz_id: $getUserDTO->organization['id'] ?? null,
            status: $getUserDTO->status ?: null,
            language: $getUserDTO->language ?: null,
            notifications: $getUserDTO->notifications ?? null,
            user_status: $getUserDTO->user_status ?: null,
            custom_fields: $getUserDTO->custom_fields ?? []
        );
    }
}
