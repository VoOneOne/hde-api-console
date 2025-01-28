<?php

declare(strict_types=1);

namespace App\TicketComment\Post;

use App\Common\Post\AddHDEResponse;
use App\TicketComment\Get\TicketCommentGetDTO;

final class TicketCommentHDEAddResponse extends AddHDEResponse
{
    public function getDTO(): TicketCommentGetDTO
    {
        return TicketCommentGetDTO::fromArray($this->data['data']);
    }
}
