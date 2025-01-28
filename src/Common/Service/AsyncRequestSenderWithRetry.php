<?php

declare(strict_types=1);

namespace App\Common\Service;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Promise\Utils;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

use function array_map;

final class AsyncRequestSenderWithRetry implements RequestSenderInterface
{
    public function send(ClientInterface $client, array $requests): array
    {
        $promises = [];
        $maxRetries = 3;

        $promises = array_map(
            fn ($request) => $this->sendWithRetry($client, $request, $maxRetries),
            $requests
        );
        $responses = Utils::settle($promises)->wait();

        return array_map(
            static function ($response) {
                if ($response['state'] === 'fulfilled') {
                    return $response['value'];
                }
                throw $response['reason'];
            },
            $responses
        );
    }

    /**
     * @return PromiseInterface
     */
    private function sendWithRetry(ClientInterface $client, RequestInterface $request, int $maxRetries)
    {
        $attempts = 0;

        $sendRequest = static function () use ($client, $request, &$attempts, $maxRetries, &$sendRequest) {
            ++$attempts;
            return $client->sendAsync($request)
                ->then(
                    static fn (ResponseInterface $response) => $response,
                    static function (RequestException $exception) use (&$attempts, $maxRetries, &$sendRequest) {
                        if ($attempts < $maxRetries) {
                            return $sendRequest();
                        }
                        throw $exception;
                    }
                );
        };

        return $sendRequest();
    }
}
