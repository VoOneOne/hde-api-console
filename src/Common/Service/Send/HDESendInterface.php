<?php

declare(strict_types=1);

namespace App\Common\Service\Send;

use App\Common\Response\HDEResponse;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;

interface HDESendInterface
{
    /**
     * @param RequestInterface[] $requests
     * @return HDEResponse[]
     */
    public function send(ClientInterface $client, array $requests): array;
}
