<?php

declare(strict_types=1);

namespace App\Common\Service\Reflector;

interface CacheInterface
{
    public function getMirror(int $srcId): ?int;

    public function setMirror(int $srcId, int $destId): void;
}
