<?php

declare(strict_types=1);

namespace App\Common\Service;

use App\Common\Response\PaginationDTO;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;

final class PaginationService
{
    public static function getPagination(ClientInterface $client, RequestInterface $request): PaginationDTO
    {
        $response = $client->send($request);
        $data = JsonService::responseToArray($response);
        return PaginationDTO::fromArray($data['pagination']);
    }
}
