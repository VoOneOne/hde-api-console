<?php

declare(strict_types=1);

namespace App\Common\Service;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Promise\Utils;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use function array_filter;
use function array_map;

final class AsyncRequestSender implements RequestSenderInterface
{
    public function send(ClientInterface $client, array $requests): array
    {
        $notFulfilledRequests = $requests;
        $fulfilledResponses = [];
        while ($notFulfilledRequests !== []) {
            $promises = $this->sendAsync($client, $notFulfilledRequests);
            $fulfilledResponses += $this->getFulfilledResponses($promises);
            $notFulfilledRequests = $this->notFulfilledRequests($promises, $requests);
        }
        return $fulfilledResponses;
    }

    public function sendAsync(ClientInterface $client, array $requests): array
    {
        $getPromises = array_map(
            static fn (RequestInterface $request) => $client->sendAsync($request),
            $requests
        );
        return Utils::settle($getPromises)->wait();
    }

    /**
     * @param RequestInterface[]
     * @return array|bool
     */
    public function notFulfilledRequests(array $promises, array $requests): array
    {
        $rejectedRequests = [];
        foreach ($promises as $requestKey => $promise) {
            if ($promise['state'] !== 'fulfilled') {
                $rejectedRequests[$requestKey] = $requests[$requestKey];
            }
        }
        return $rejectedRequests;
    }

    /**
     * @return ResponseInterface[]
     */
    public function getFulfilledResponses(array $promises): array
    {
        $fulfilledPromises = array_filter(
            $promises,
            static fn ($promise) => $promise['state'] === 'fulfilled'
        );
        return array_map(
            static fn ($promise) => $promise['value'],
            $fulfilledPromises
        );
    }
}
