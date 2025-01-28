<?php

declare(strict_types=1);

namespace App\Common\Response;

use App\Common\Service\JsonService;
use Psr\Http\Message\ResponseInterface;

final class HDEResponse
{
    private array $data;

    public function __construct(private ResponseInterface $response)
    {
        $this->data = JsonService::responseToArray($this->response);
    }

    public function getPagination(): PaginationDTO
    {
        return PaginationDTO::fromArray($this->data['pagination']);
    }

    public function getLimit(): ?int
    {
        return $this->response->getHeader('X-Rate-Limit-Remaining')[0] ?? null;
    }
}
