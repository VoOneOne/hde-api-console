<?php

declare(strict_types=1);

namespace App\TicketPost\Get\Send;

use App\Common\Get\Send\GetHDESendInterface;
use App\Common\Service\RequestSenderInterface;
use App\TicketPost\Get\Response\TicketPostHDEGetResponse;
use GuzzleHttp\ClientInterface;

use function array_map;

final class TicketPostHDEGetSend implements GetHDESendInterface
{
    public function __construct(private RequestSenderInterface $requestSender) {}

    public function send(ClientInterface $client, array $requests): array
    {
        return array_map(
            static fn ($response) => new TicketPostHDEGetResponse($response),
            $this->requestSender->send($client, $requests)
        );
    }
}
