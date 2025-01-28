<?php

declare(strict_types=1);

namespace App\User\Post;

use App\Common\Post\AddHDEResponse;
use App\User\Get\UserGetDTO;

final class UserAddResponse extends AddHDEResponse
{
    public function getDTO(): UserGetDTO
    {
        return UserGetDTO::fromArray($this->data['data']);
    }
}
