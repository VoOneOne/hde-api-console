<?php

declare(strict_types=1);

namespace App\Common\Service\Send;

use App\Common\Get\HDEGetResponse;
use App\Common\Post\AddHDEResponse;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;

use function array_chunk;

final class SendChunks
{
    /**
     * @param RequestInterface[] $requests
     * @return AddHDEResponse[]|HDEGetResponse[]
     */
    public static function send(ClientInterface $client, HDESendInterface $send, array $requests, int $chunkLength): array
    {
        $responses = [];
        foreach (array_chunk($requests, $chunkLength, true) as $chunkRequests) {
            $responses[] = $send->send($client, $chunkRequests);
        }
        return self::mergeChunks($responses);
    }

    public static function mergeChunks(array $chunks): array
    {
        $result = [];
        foreach ($chunks as $chunk) {
            $result += $chunk;
        }
        return $result;
    }
}
