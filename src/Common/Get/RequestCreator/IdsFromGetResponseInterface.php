<?php

declare(strict_types=1);

namespace App\Common\Get\RequestCreator;

use App\Common\Get\HDEGetResponse;

interface IdsFromGetResponseInterface
{
    /**
     * @param HDEGetResponse[] $getResponses
     * @return array<int>
     */
    public function getIds(array $getResponses): array;
}
