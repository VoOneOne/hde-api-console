<?php

declare(strict_types=1);

namespace App\User\Get\RequestCreator;

use App\Common\Get\RequestCreator\GetRequestCreatorInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

final class UserGetRequestCreator implements GetRequestCreatorInterface
{
    public function getRequest(array $query, array $args = []): RequestInterface
    {
        return new Request('GET', 'users/?' . http_build_query($query));
    }
}
