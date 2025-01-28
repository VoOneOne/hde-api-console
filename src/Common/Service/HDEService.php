<?php

declare(strict_types=1);

namespace App\Common\Service;

use App\User\Get\Service\GetUserRequestsCreator;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\ResponseInterface;

use function sleep;

final class HDEService
{
    public static function getLimitFromResponse(ResponseInterface $response): ?int
    {
        return $response->getHeader('X-Rate-Limit-Remaining')[0] ?? null;
    }

    /**
     * @param ResponseInterface[] $responses
     */
    public static function getLimitFromResponses(array $responses): ?int
    {
        $minLimit = null;
        foreach ($responses as $response) {
            $limit = self::getLimitFromResponse($response);
            if ($minLimit > $limit) {
                $minLimit = $limit;
            }
        }
        return $minLimit;
    }

    public static function sleepIfNeeded(int $limit, $requestsCount): void
    {
        if ($requestsCount >= $limit) {
            sleep(60);
        }
    }

    public static function sendTestRequestAndGetLimit(ClientInterface $client): int
    {
        $response = $client->send(GetUserRequestsCreator::createGetUsersRequest(1));
        return self::getLimitFromResponse($response) ?: 0;
    }
}
