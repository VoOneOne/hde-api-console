<?php

declare(strict_types=1);

namespace App\TicketPost\Post;

use App\Common\Post\AddHDEResponse;
use App\TicketPost\Get\TicketPostGetDTO;

final class TicketPostHDEAddResponse extends AddHDEResponse
{
    public function getDTO(): TicketPostGetDTO
    {
        return TicketPostGetDTO::fromArray($this->data['data']);
    }
}
