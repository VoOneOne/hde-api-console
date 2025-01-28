<?php

declare(strict_types=1);

namespace App\Common\Service\RequestCreator;

use Psr\Http\Message\ResponseInterface;

interface ResponsesToIdsInterface
{
    /**
     * @var ResponseInterface[]
     */
    public function getIds(array $responses): array;
}
