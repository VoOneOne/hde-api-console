<?php

declare(strict_types=1);

namespace App\Ticket\Common;

use App\Common\Get\GetDTO;
use App\Common\Post\AddDTO;
use App\Common\Service\Reflector\AbstractCache;
use App\Common\Service\Reflector\ReflectorInterface;
use App\Ticket\Get\TicketGetDTO;
use App\Ticket\Post\AddTicketDTO;
use DI\Attribute\Inject;

final class TicketReflector implements ReflectorInterface
{
    public function __construct(
        #[Inject(name: 'cache.user')]
        private AbstractCache $cache
    ) {}

    /**
     * @param TicketGetDTO $dto
     * @return AddTicketDTO
     */
    public function reflect(GetDTO $dto): AddDTO
    {
        return new AddTicketDTO(
            $dto->title,
            $dto->description,
            $this->getReflectId($dto->owner_id),
            $this->getReflectId($dto->user_id),
            $dto->user_email,
            $dto->status_id,
            $dto->priority_id,
            $dto->type_id
        );
    }

    public function getReflectId(?int $srcId): ?int
    {
        if ($srcId === null) {
            return null;
        }
        return $this->cache->getMirror($srcId);
    }
}
