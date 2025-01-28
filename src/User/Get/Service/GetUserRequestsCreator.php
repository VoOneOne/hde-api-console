<?php

declare(strict_types=1);

namespace App\User\Get\Service;

use App\Common\Service\PaginationService;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

use function array_combine;
use function array_map;
use function http_build_query;
use function range;

final class GetUserRequestsCreator
{
    public function __construct(private PaginationService $paginationService) {}

    /**
     * @return RequestInterface[]
     */
    public function createGetRequests(array $params): array
    {
        $client = $params['client'];
        return array_map(
            static fn (int $page) => self::createGetUsersRequest($page),
            $this->getPages($client)
        );
    }

    public static function createGetUsersRequest(int $page): RequestInterface
    {
        return new Request(
            'GET',
            'users/?' . http_build_query([
                'page' => $page,
                'order_by' => 'date_created{asc}',
            ])
        );
    }

    private function getPages(ClientInterface $client): array
    {
        $request = self::createGetUsersRequest(1);
        $paginationDTO = $this->paginationService->getPagination($client, $request);
        $pagesCount = $paginationDTO->total_pages;
        $pages = range(1, $pagesCount);
        return array_combine($pages, $pages);
    }
}
