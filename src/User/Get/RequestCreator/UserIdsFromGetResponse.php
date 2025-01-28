<?php

declare(strict_types=1);

namespace App\User\Get\RequestCreator;

use App\Common\Get\RequestCreator\BaseIdsFromGetResponse;

use function array_diff;

final class UserIdsFromGetResponse extends BaseIdsFromGetResponse
{
    public function getIds(array $getResponses): array
    {
        return array_diff(parent::getIds($getResponses), [1, 2]);
    }
}
