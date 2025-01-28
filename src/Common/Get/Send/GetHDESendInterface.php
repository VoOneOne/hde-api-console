<?php

declare(strict_types=1);

namespace App\Common\Get\Send;

use App\Common\Get\HDEGetResponse;
use App\Common\Service\Send\HDESendInterface;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;

interface GetHDESendInterface extends HDESendInterface
{
    /**
     * @param RequestInterface[] $requests
     * @return HDEGetResponse[]
     */
    public function send(ClientInterface $client, array $requests): array;
}
