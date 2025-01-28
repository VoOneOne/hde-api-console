<?php

declare(strict_types=1);

namespace App\TicketComment\Get\Response;

use App\Common\Get\GetDTO;
use App\Common\Get\HDEGetResponse;
use App\TicketComment\Get\TicketCommentGetDTO;

final class TicketCommentHDEGetResponse extends HDEGetResponse
{
    public function createDTO(array $data): GetDTO
    {
        return TicketCommentGetDTO::fromArray($data);
    }
}
