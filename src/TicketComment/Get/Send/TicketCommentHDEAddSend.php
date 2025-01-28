<?php

declare(strict_types=1);

namespace App\TicketComment\Get\Send;

use App\Common\Post\Send\HDEAddSendInterface;
use App\Common\Service\RequestSenderInterface;
use App\TicketComment\Post\TicketCommentHDEAddResponse;
use GuzzleHttp\ClientInterface;

use function array_map;

final class TicketCommentHDEAddSend implements HDEAddSendInterface
{
    public function __construct(private RequestSenderInterface $requestSender) {}

    public function send(ClientInterface $client, array $requests): array
    {
        return array_map(
            static fn ($response) => new TicketCommentHDEAddResponse($response),
            $this->requestSender->send($client, $requests)
        );
    }
}
