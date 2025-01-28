<?php

declare(strict_types=1);

namespace App\Common\Service;

use Psr\Http\Message\ResponseInterface;

use function json_decode;

final class JsonService
{
    public static function jsonToArray(string $json): array
    {
        return json_decode($json, true, 512, JSON_THROW_ON_ERROR);
    }

    public static function responseToArray(ResponseInterface $response): array
    {
        return self::jsonToArray($response->getBody()->getContents());
    }
}
