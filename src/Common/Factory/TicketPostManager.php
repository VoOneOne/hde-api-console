<?php

declare(strict_types=1);

namespace App\Common\Factory;

use App\Common\Delete\RequestCreator\DeleteRequestCreatorInterface;
use App\Common\Get\RequestCreator\AllGetRequestsCreatorInterface;
use App\Common\Get\RequestCreator\BaseIdsFromGetResponse;
use App\Common\Get\RequestCreator\IdsFromGetResponseInterface;
use App\Common\Get\Send\GetHDESendInterface;
use App\Common\Post\RequestCreator\AddRequestCreatorInterface;
use App\Common\Post\Send\HDEAddSendInterface;
use App\Common\Service\Reflector\CacheInterface;
use App\Common\Service\Reflector\NullCache;
use App\Common\Service\Reflector\ReflectorInterface;
use App\TicketPost\Common\TicketPostReflector;
use App\TicketPost\Delete\RequestCreator\TicketPostDeleteRequestCreator;
use App\TicketPost\Get\RequestCreator\TicketPostAllGetRequestsCreator;
use App\TicketPost\Get\Send\TicketPostHDEAddSend;
use App\TicketPost\Get\Send\TicketPostHDEGetSend;
use App\TicketPost\Post\RequestCreator\TicketPostAddRequestCreator;

final class TicketPostManager extends AbstractManager
{
    public function allGetRequestsCreator(): AllGetRequestsCreatorInterface
    {
        return $this->container->get(TicketPostAllGetRequestsCreator::class);
    }

    public function getSend(): GetHDESendInterface
    {
        return $this->container->get(TicketPostHDEGetSend::class);
    }

    public function idsFromGetResponse(): IdsFromGetResponseInterface
    {
        return $this->container->get(BaseIdsFromGetResponse::class);
    }

    public function getDeleteRequestCreator(): DeleteRequestCreatorInterface
    {
        return new TicketPostDeleteRequestCreator();
    }

    public function reflector(): ReflectorInterface
    {
        return $this->container->get(TicketPostReflector::class);
    }

    public function cache(): CacheInterface
    {
        return new NullCache();
    }

    public function addRequestCreator(): AddRequestCreatorInterface
    {
        return $this->container->get(TicketPostAddRequestCreator::class);
    }

    public function addSend(): HDEAddSendInterface
    {
        return $this->container->get(TicketPostHDEAddSend::class);
    }
}
