<?php

declare(strict_types=1);

namespace App\User\Delete\RequestCreator;

use App\Common\Delete\RequestCreator\DeleteRequestCreatorInterface;
use App\Common\Get\GetDTO;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

final class UserDeleteRequestCreator implements DeleteRequestCreatorInterface
{
    public function deleteRequest(GetDTO $getDTO): RequestInterface
    {
        return new Request('DELETE', 'users/' . $getDTO->getId());
    }
}
