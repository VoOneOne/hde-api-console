<?php

declare(strict_types=1);

namespace App\Ticket\Post;

use App\Common\Post\AddHDEResponse;
use App\Ticket\Get\TicketGetDTO;

final class TicketHDEAddResponse extends AddHDEResponse
{
    public function getDTO(): TicketGetDTO
    {
        return TicketGetDTO::fromArray($this->data['data']);
    }
}
