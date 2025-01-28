<?php

declare(strict_types=1);

namespace App\TicketComment\Delete\RequestCreator;

use App\Common\Delete\RequestCreator\DeleteRequestCreatorInterface;
use App\Common\Get\GetDTO;
use App\TicketComment\Get\TicketCommentGetDTO;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

final class TicketCommentDeleteRequestCreator implements DeleteRequestCreatorInterface
{
    /**
     * @param TicketCommentGetDTO $getDTO
     */
    public function deleteRequest(GetDTO $getDTO): RequestInterface
    {
        return new Request('DELETE', 'tickets/' . $getDTO->ticket_id . '/comments/' . $getDTO->id);
    }
}
