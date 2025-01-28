<?php

declare(strict_types=1);

namespace App\Ticket\Get;

use App\Common\Get\GetDTO;

final class TicketGetDTO extends GetDTO
{
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public int $owner_id,
        public ?int $user_id,
        public ?string $user_email,
        public ?string $status_id,
        public ?int $priority_id,
        public ?int $type_id
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['id'],
            $data['title'],
            $data['description'] ?? 'Требуется описание',
            $data['owner_id'],
            $data['user_id'],
            $data['user_email'],
            $data['status_id'],
            $data['priority_id'],
            $data['type_id']
        );
    }
}
