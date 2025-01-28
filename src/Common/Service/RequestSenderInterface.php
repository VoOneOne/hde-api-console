<?php

declare(strict_types=1);

namespace App\Common\Service;

use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface RequestSenderInterface
{
    /**
     * @param RequestInterface[] $requests
     * @return ResponseInterface[]
     */
    public function send(ClientInterface $client, array $requests): array;
}
