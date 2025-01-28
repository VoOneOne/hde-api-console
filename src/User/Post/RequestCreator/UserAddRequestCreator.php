<?php

declare(strict_types=1);

namespace App\User\Post\RequestCreator;

use App\Common\Post\AddDTO;
use App\Common\Post\RequestCreator\AddRequestCreatorInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

final class UserAddRequestCreator implements AddRequestCreatorInterface
{
    public function postRequest(AddDTO $dto): RequestInterface
    {
        return new Request(
            method: 'POST',
            uri: $dto->getUri(),
            headers: ['Content-Type' => 'application/x-www-form-urlencoded'],
            body: $dto->getBodyParams()
        );
    }
}
