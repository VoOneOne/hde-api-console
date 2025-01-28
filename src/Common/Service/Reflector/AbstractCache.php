<?php

declare(strict_types=1);

namespace App\Common\Service\Reflector;

use Psr\Cache\CacheItemPoolInterface;

final class AbstractCache implements CacheInterface
{
    public function __construct(
        private CacheItemPoolInterface $cacheItemPool,
        private string $cashKey
    ) {}

    public function getMirror(int $srcId): ?int
    {
        $item = $this->cacheItemPool->getItem(
            $this->getMirrorKey($srcId)
        );
        if (!$item->isHit()) {
            return null;
        }
        return $item->get();
    }

    public function setMirror(int $srcId, int $destId): void
    {
        $item = $this->cacheItemPool->getItem($this->getMirrorKey($srcId));
        $item->set($destId);
        $this->cacheItemPool->save($item);
    }

    private function getMirrorKey(int $id): string
    {
        return $this->cashKey . $id;
    }
}
