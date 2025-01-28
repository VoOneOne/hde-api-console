<?php

declare(strict_types=1);

namespace App\Common\Service\Send;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Promise\Utils;
use Psr\Http\Message\RequestInterface;

use function array_map;

final class AsyncSendService
{
    public static function send(ClientInterface $client, array $requests): array
    {
        $getPromises = array_map(
            static fn (RequestInterface $request) => $client->sendAsync($request),
            $requests
        );
        return Utils::settle($getPromises)->wait();
    }
}
