<?php

declare(strict_types=1);

namespace App\Common\Service\Send;

use App\Common\Service\HDEService;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

use function array_map;

final class FulfilledAsyncService
{
    /**
     * @return ResponseInterface[]
     */
    public static function send(ClientInterface $client, array $requests): array
    {
        while (true) {
            $promises = AsyncSendService::send($client, $requests);
            $responses = self::getResponses($promises);
            $limit = HDEService::getLimitFromResponses($responses);
            if ($limit === null) {
                $limit = HDEService::sendTestRequestAndGetLimit($client);
            }
            HDEService::sendTestRequestAndGetLimit($client);
            HDEService::sleepIfNeeded($limit, \count($requests));
            if (self::promisesHasRejected($promises)) {
                continue;
            }
            return $responses;
        }
    }

    public static function getResponses(array $promises): array
    {
        return array_map(static fn ($promise) => $promise['value'], $promises);
    }

    public static function promisesHasRejected(array $promises): bool
    {
        foreach ($promises as $promise) {
            if ($promise['state'] === 'rejected') {
                return true;
            }
        }
        return false;
    }
}
