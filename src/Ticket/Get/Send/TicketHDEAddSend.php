<?php

declare(strict_types=1);

namespace App\Ticket\Get\Send;

use App\Common\Post\Send\HDEAddSendInterface;
use App\Common\Service\RequestSenderInterface;
use App\Ticket\Post\TicketHDEAddResponse;
use GuzzleHttp\ClientInterface;

use function array_map;

final class TicketHDEAddSend implements HDEAddSendInterface
{
    public function __construct(private RequestSenderInterface $requestSender) {}

    public function send(ClientInterface $client, array $requests): array
    {
        return array_map(
            static fn ($response) => new TicketHDEAddResponse($response),
            $this->requestSender->send($client, $requests)
        );
    }
}
