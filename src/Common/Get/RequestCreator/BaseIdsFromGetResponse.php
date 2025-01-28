<?php

declare(strict_types=1);

namespace App\Common\Get\RequestCreator;

use App\Common\Get\GetDTO;
use App\Common\Get\HDEGetResponse;

use function array_map;
use function array_merge;

final class BaseIdsFromGetResponse implements IdsFromGetResponseInterface
{
    /**
     * @param HDEGetResponse[] $getResponses
     * @return array<int>
     */
    public function getIds(array $getResponses): array
    {
        $ids = [];
        foreach ($getResponses as $response) {
            $ids[] = array_map(
                static fn (GetDTO $DTO) => $DTO->getId(),
                $response->getDTOs()
            );
        }
        return array_merge(...$ids);
    }
}
