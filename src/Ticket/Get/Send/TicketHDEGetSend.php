<?php

declare(strict_types=1);

namespace App\Ticket\Get\Send;

use App\Common\Get\Send\GetHDESendInterface;
use App\Common\Service\RequestSenderInterface;
use App\Ticket\Get\Response\TicketHDEGetResponse;
use GuzzleHttp\ClientInterface;

use function array_map;

final class TicketHDEGetSend implements GetHDESendInterface
{
    public function __construct(private RequestSenderInterface $requestSender) {}

    public function send(ClientInterface $client, array $requests): array
    {
        return array_map(
            static fn ($response) => new TicketHDEGetResponse($response),
            $this->requestSender->send($client, $requests)
        );
    }
}
