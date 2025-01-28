<?php

declare(strict_types=1);

namespace App\User\Get\Service;

use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

final class DeleteUserRequestCreator
{
    public function createDeleteRequests(array $params): array
    {
        $ids = $params['ids'] ?? [];
        return array_map(
            static fn (int $id) => self::createDeleteUserRequest($id),
            $ids
        );
    }

    public static function createDeleteUserRequest(int $id): RequestInterface
    {
        return new Request('DELETE', 'users/' . $id);
    }
}
