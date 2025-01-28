<?php

declare(strict_types=1);

namespace App\Common\Get\RequestCreator;

use Psr\Http\Message\RequestInterface;

interface GetRequestCreatorInterface
{
    public function getRequest(array $query, array $args = []): RequestInterface;
}
