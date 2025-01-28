<?php

declare(strict_types=1);

namespace App\Common\Response;

final class PaginationDTO
{
    public function __construct(
        public int $total,
        public int $per_page,
        public int $current_page,
        public int $total_pages,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['total'],
            $data['per_page'],
            $data['current_page'],
            $data['total_pages'],
        );
    }
}
