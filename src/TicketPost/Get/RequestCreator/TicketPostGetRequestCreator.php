<?php

declare(strict_types=1);

namespace App\TicketPost\Get\RequestCreator;

use App\Common\Get\RequestCreator\GetRequestCreatorInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

final class TicketPostGetRequestCreator implements GetRequestCreatorInterface
{
    public function getRequest(array $query, array $args = []): RequestInterface
    {
        return new Request('GET', 'tickets/' . $args['ticket_id'] . '/posts/?' . http_build_query($query));
    }
}
