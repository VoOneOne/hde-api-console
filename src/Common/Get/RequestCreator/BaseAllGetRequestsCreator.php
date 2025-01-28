<?php

declare(strict_types=1);

namespace App\Common\Get\RequestCreator;

use App\Common\Get\HDEGetResponse;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;

use function array_combine;
use function range;

abstract class BaseAllGetRequestsCreator implements AllGetRequestsCreatorInterface
{
    abstract public function getRequests(ClientInterface $client): array;

    final public function getPages(ClientInterface $client, RequestInterface $request): array
    {
        $response = new HDEGetResponse($client->send($request));
        $pagesCount = $response->getPagination()->total_pages;
        $pages = range(1, $pagesCount);
        return array_combine($pages, $pages);
    }
}
