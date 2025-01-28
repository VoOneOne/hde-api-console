<?php

declare(strict_types=1);

namespace App\User\Get\Response;

use App\Common\Get\GetDTO;
use App\Common\Get\HDEGetResponse;
use App\User\Get\UserGetDTO;

final class UserHDEGetResponse extends HDEGetResponse
{
    public function createDTO(array $data): GetDTO
    {
        return UserGetDTO::fromArray($data);
    }
}
