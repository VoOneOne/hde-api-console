<?php

declare(strict_types=1);

namespace App\Ticket\Get\Response;

use App\Common\Get\GetDTO;
use App\Common\Get\HDEGetResponse;
use App\Ticket\Get\TicketGetDTO;

final class TicketHDEGetResponse extends HDEGetResponse
{
    public function createDTO(array $data): GetDTO
    {
        return TicketGetDTO::fromArray($data);
    }
}
