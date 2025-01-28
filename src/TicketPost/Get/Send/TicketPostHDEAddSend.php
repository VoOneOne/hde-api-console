<?php

declare(strict_types=1);

namespace App\TicketPost\Get\Send;

use App\Common\Post\Send\HDEAddSendInterface;
use App\Common\Service\RequestSenderInterface;
use App\TicketPost\Post\TicketPostHDEAddResponse;
use GuzzleHttp\ClientInterface;

use function array_map;

final class TicketPostHDEAddSend implements HDEAddSendInterface
{
    public function __construct(private RequestSenderInterface $requestSender) {}

    public function send(ClientInterface $client, array $requests): array
    {
        return array_map(
            static fn ($response) => new TicketPostHDEAddResponse($response),
            $this->requestSender->send($client, $requests)
        );
    }
}
