<?php

declare(strict_types=1);

namespace App\Ticket\Services;

use App\Common\Common\GetResponseToAddRequestInterface;
use App\User\Common\UserCache;
use Psr\Http\Message\ResponseInterface;

use function array_map;
use function json_decode;

final class GetResponseToAddRequest implements GetResponseToAddRequestInterface
{
    public function __construct(private UserCache $userCache) {}

    public function createAddRequests(array $getResponses): array
    {
        $tickets = $this->getTicketsWithIdKey($getResponses);
        $addTickets = array_map(
            [$this, 'ticketToAddTicket'],
            $tickets
        );
        return $this->createAddTicketRequests($addTickets);
    }

    public function ticketToAddTicket(array $ticket): array
    {
        $ownerId = null;
        if (isset($ticket['owner_id'])) {
            if ($ticket['owner_id'] > 0) {
                $ownerId = $this->userCache->getMirror($ticket['owner_id']);
            } else {
                $ownerId = 0;
            }
        }
        $userId = null;
        if (isset($ticket['user_id'])) {
            if ($ticket['user_id'] > 0) {
                $userId = $this->userCache->getMirror($ticket['user_id']);
            } else {
                $userId = 0;
            }
        }
        return [
            'title' => $ticket['title'] ?? ' ',
            'description' => $ticket['description'] ?? 'empty',
            'owner_id' => $ownerId,
            'user_id' => $userId,
            'user_email' => $ticket['user_email'] ?? null,
        ];
    }

    public function createAddTicketRequests(array $addTickets): array
    {
        return array_map(
            static fn ($addTicket) => [
                'method' => 'POST',
                'uri' => 'tickets/',
                'options' => [
                    'form_params' => $addTicket,
                ],
            ],
            $addTickets
        );
    }

    public function jsonToArray(string $json): array
    {
        return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    }

    public function responseToArray(ResponseInterface $response): array
    {
        return $this->jsonToArray($response->getBody()->getContents());
    }

    private function getTicketsWithIdKey(array $fulfilledResponse): array
    {
        $tickets = [];
        foreach ($fulfilledResponse as $responseData) {
            $data = $this->responseToArray($responseData['value']);
            foreach ($data['data'] as $ticket) {
                if ($ticket['id'] === 1 || $ticket['id'] === 2) {
                    continue;
                }
                $tickets[(int)$ticket['id']] = $ticket;
            }
        }
        return $tickets;
    }
}
