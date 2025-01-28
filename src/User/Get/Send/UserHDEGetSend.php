<?php

declare(strict_types=1);

namespace App\User\Get\Send;

use App\Common\Get\Send\GetHDESendInterface;
use App\Common\Service\RequestSenderInterface;
use App\User\Get\Response\UserHDEGetResponse;
use GuzzleHttp\ClientInterface;

use function array_map;

final class UserHDEGetSend implements GetHDESendInterface
{
    public function __construct(private RequestSenderInterface $requestSender) {}

    public function send(ClientInterface $client, array $requests): array
    {
        return array_map(
            static fn ($response) => new UserHDEGetResponse($response),
            $this->requestSender->send($client, $requests)
        );
    }
}
