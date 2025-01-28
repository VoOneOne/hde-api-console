<?php

declare(strict_types=1);

namespace App\Ticket\Post;

use App\Common\Post\AddDTO;

final class AddTicketDTO extends AddDTO
{
    public function __construct(
        public string $title,
        public string $description,
        public ?int $owner_id,
        public ?int $user_id,
        public ?string $user_email,
        public ?string $status_id,
        public ?int $priority_id,
        public ?int $type_id
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['title'],
            $data['description'],
            $data['owner_id'],
            $data['user_id'],
            $data['user_email'],
            $data['status_id'],
            $data['priority_id'],
            $data['type_id']
        );
    }

    public function getUri(): string
    {
        return 'tickets/';
    }
}
