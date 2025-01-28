<?php

declare(strict_types=1);

namespace App\TicketPost\Get\RequestCreator;

use App\Common\Get\RequestCreator\BaseAllGetRequestsCreator;
use App\Common\Get\RequestCreator\BaseIdsFromGetResponse;
use App\Common\Service\Send\SendChunks;
use App\Ticket\Get\RequestCreator\TicketAllGetRequestsCreator;
use App\Ticket\Get\Response\TicketHDEGetResponse;
use App\Ticket\Get\Send\TicketHDEGetSend;
use GuzzleHttp\ClientInterface;

use function array_map;
use function array_merge;

final class TicketPostAllGetRequestsCreator extends BaseAllGetRequestsCreator
{
    public const CHUNK_SIZE = 50;

    public function __construct(
        private TicketAllGetRequestsCreator $ticketAllGetRequestsCreator,
        private TicketHDEGetSend $send,
        private BaseIdsFromGetResponse $idsFromGetResponse,
        private TicketPostGetRequestCreator $getRequestCreator,
    ) {}

    public function getRequests(ClientInterface $client): array
    {
        $getTicketsPostRequests = [];
        foreach ($this->getTicketsIds($client) as $ticketId) {
            $requestForPages = $this->getRequestCreator->getRequest(
                ['page' => 1],
                ['ticket_id' => $ticketId]
            );
            $pages = $this->getPages($client, $requestForPages);
            $getTicketsPostRequests[] = array_map(
                fn (int $page) => $this->getRequestCreator->getRequest(
                    ['page' => $page],
                    ['ticket_id' => $ticketId]
                ),
                $pages
            );
        }
        return array_merge(...$getTicketsPostRequests);
    }

    private function getTicketsIds(ClientInterface $client): array
    {
        $ticketGetRequests = $this->ticketAllGetRequestsCreator->getRequests($client);
        /**
         * @var TicketHDEGetResponse[] $getResponses
         */
        $getResponses = SendChunks::send($client, $this->send, $ticketGetRequests, self::CHUNK_SIZE);
        return $this->idsFromGetResponse->getIds($getResponses);
    }
}
