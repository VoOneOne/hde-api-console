<?php

declare(strict_types=1);

namespace App\TicketPost\Delete\RequestCreator;

use App\Common\Delete\RequestCreator\DeleteRequestCreatorInterface;
use App\Common\Get\GetDTO;
use App\TicketPost\Get\TicketPostGetDTO;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

final class TicketPostDeleteRequestCreator implements DeleteRequestCreatorInterface
{
    /**
     * @param TicketPostGetDTO $getDTO
     */
    public function deleteRequest(GetDTO $getDTO): RequestInterface
    {
        return new Request('DELETE', 'tickets/' . $getDTO->ticket_id . '/posts/' . $getDTO->id);
    }
}
