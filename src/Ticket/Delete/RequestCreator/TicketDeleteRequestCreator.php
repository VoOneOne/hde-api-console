<?php

declare(strict_types=1);

namespace App\Ticket\Delete\RequestCreator;

use App\Common\Delete\RequestCreator\DeleteRequestCreatorInterface;
use App\Common\Get\GetDTO;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

final class TicketDeleteRequestCreator implements DeleteRequestCreatorInterface
{
    public function deleteRequest(GetDTO $getDTO): RequestInterface
    {
        return new Request('DELETE', 'tickets/' . $getDTO->getId());
    }
}
