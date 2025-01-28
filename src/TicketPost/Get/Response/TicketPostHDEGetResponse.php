<?php

declare(strict_types=1);

namespace App\TicketPost\Get\Response;

use App\Common\Get\GetDTO;
use App\Common\Get\HDEGetResponse;
use App\TicketPost\Get\TicketPostGetDTO;

final class TicketPostHDEGetResponse extends HDEGetResponse
{
    public function createDTO(array $data): GetDTO
    {
        return TicketPostGetDTO::fromArray($data);
    }
}
