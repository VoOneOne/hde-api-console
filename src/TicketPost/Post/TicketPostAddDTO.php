<?php

declare(strict_types=1);

namespace App\TicketPost\Post;

use App\Common\Post\AddDTO;

use function http_build_query;

final class TicketPostAddDTO extends AddDTO
{
    public function __construct(
        public int $ticket_id,
        public string $text,
        public int $user_id,
    ) {}

    public function toArray(): array
    {
        return [
            'ticket_id' => $this->ticket_id,
            'text' => $this->text,
            'user_id' => $this->user_id,
        ];
    }

    public function getUri(): string
    {
        return 'tickets/' . $this->ticket_id . '/posts/';
    }

    public function getBodyParams(): string
    {
        return http_build_query(['text' => $this->text, 'user_id' => $this->user_id]);
    }
}
