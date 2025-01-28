<?php

namespace Tests\Unit\Common\Service;

use App\Common\Service\AsyncRequestSenderWithRetry;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Promise\RejectedPromise;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class AsyncRequestSenderWithRetryTest extends TestCase
{
    public function testSendSuccess()
    {
        $client = $this->createMock(ClientInterface::class);

        $requests = [
            new Request('GET', 'https://api.example.com/success1'),
            new Request('GET', 'https://api.example.com/success2'),
        ];

        $client->method('sendAsync')
            ->willReturnOnConsecutiveCalls(
                new FulfilledPromise(new Response(200, [], 'Success1')),
                new FulfilledPromise(new Response(200, [], 'Success2'))
            );

        $sender = new AsyncRequestSenderWithRetry();
        $responses = $sender->send($client, $requests);

        $this->assertCount(2, $responses);
        $this->assertInstanceOf(ResponseInterface::class, $responses[0]);
        $this->assertEquals('Success1', (string)$responses[0]->getBody());
        $this->assertEquals('Success2', (string)$responses[1]->getBody());
    }

    public function testSendWithRetryAndSuccess()
    {
        $client = $this->createMock(ClientInterface::class);

        $requests = [
            new Request('GET', 'https://api.example.com/retry'),
        ];

        $client->method('sendAsync')
            ->willReturnOnConsecutiveCalls(
                new RejectedPromise(new RequestException('Temporary error', $requests[0])),
                new FulfilledPromise(new Response(200, [], 'Success after retry'))
            );

        $sender = new AsyncRequestSenderWithRetry();
        $responses = $sender->send($client, $requests);

        $this->assertCount(1, $responses);
        $this->assertInstanceOf(ResponseInterface::class, $responses[0]);
        $this->assertEquals('Success after retry', (string)$responses[0]->getBody());
    }

    public function testSendExceedsRetryLimit()
    {
        $this->expectException(RequestException::class);

        $client = $this->createMock(ClientInterface::class);

        $requests = [
            new Request('GET', 'https://api.example.com/failure'),
        ];

        $client->method('sendAsync')
            ->willReturn(new RejectedPromise(new RequestException('Permanent error', $requests[0])));

        $sender = new AsyncRequestSenderWithRetry();
        $sender->send($client, $requests);
    }

    public function testSendMixedResults()
    {
        $this->expectException(RequestException::class);

        $client = $this->createMock(ClientInterface::class);

        $requests = [
            new Request('GET', 'https://api.example.com/success'),
            new Request('GET', 'https://api.example.com/failure'),
        ];

        $client->method('sendAsync')
            ->willReturnOnConsecutiveCalls(
                new FulfilledPromise(new Response(200, [], 'Success')),
                new RejectedPromise(new RequestException('Permanent error', $requests[1])),
                new RejectedPromise(new RequestException('Permanent error', $requests[1])),
                new RejectedPromise(new RequestException('Permanent error', $requests[1]))
            );

        $sender = new AsyncRequestSenderWithRetry();
        $sender->send($client, $requests);
    }
}
