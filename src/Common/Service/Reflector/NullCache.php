<?php

declare(strict_types=1);

namespace App\Common\Service\Reflector;

final class NullCache implements CacheInterface
{
    public function setMirror(int $srcId, int $destId): void {}

    public function getMirror(int $srcId): ?int
    {
        return null;
    }
}
