<?php

declare(strict_types=1);

namespace App\Common\Service\RequestCreator;

interface GetRequestCreatorFromPagesInterface
{
    public function createGetResponseFromPages(array $pages): array;
}
