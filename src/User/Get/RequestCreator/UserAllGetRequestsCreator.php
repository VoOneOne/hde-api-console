<?php

declare(strict_types=1);

namespace App\User\Get\RequestCreator;

use App\Common\Get\RequestCreator\BaseAllGetRequestsCreator;
use GuzzleHttp\ClientInterface;

use function array_map;

final class UserAllGetRequestsCreator extends BaseAllGetRequestsCreator
{
    public function __construct(
        private UserGetRequestCreator $requestCreator
    ) {}

    public function getRequests(ClientInterface $client): array
    {
        return array_map(
            fn (int $page) => $this->requestCreator->getRequest(['page' => $page, 'order_by' => 'date_created{asc}']),
            $this->getPages($client, $this->requestCreator->getRequest(['page' => 1]))
        );
    }
}
