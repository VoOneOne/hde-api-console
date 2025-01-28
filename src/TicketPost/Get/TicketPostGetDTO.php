<?php

declare(strict_types=1);

namespace App\TicketPost\Get;

use App\Common\Get\GetDTO;

final class TicketPostGetDTO extends GetDTO
{
    public function __construct(
        public int $id,
        public int $ticket_id,
        public string $text,
        public int $user_id,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['ticket_id'],
            $data['text'],
            $data['user_id'],
        );
    }
}
