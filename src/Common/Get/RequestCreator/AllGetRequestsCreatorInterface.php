<?php

declare(strict_types=1);

namespace App\Common\Get\RequestCreator;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;

interface AllGetRequestsCreatorInterface
{
    /**
     * @return RequestInterface[]
     */
    public function getRequests(ClientInterface $client): array;
}
