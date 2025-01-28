<?php

declare(strict_types=1);

namespace App\TicketComment\Get\Send;

use App\Common\Get\Send\GetHDESendInterface;
use App\Common\Service\RequestSenderInterface;
use App\TicketComment\Get\Response\TicketCommentHDEGetResponse;
use GuzzleHttp\ClientInterface;

use function array_map;

final class TicketCommentHDEGetSend implements GetHDESendInterface
{
    public function __construct(private RequestSenderInterface $requestSender) {}

    public function send(ClientInterface $client, array $requests): array
    {
        return array_map(
            static fn ($response) => new TicketCommentHDEGetResponse($response),
            $this->requestSender->send($client, $requests)
        );
    }
}
