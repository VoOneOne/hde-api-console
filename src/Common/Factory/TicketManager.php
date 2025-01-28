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
use App\Common\Service\Reflector\AbstractCache;
use App\Common\Service\Reflector\ReflectorInterface;
use App\Ticket\Common\TicketReflector;
use App\Ticket\Delete\RequestCreator\TicketDeleteRequestCreator;
use App\Ticket\Get\RequestCreator\TicketAllGetRequestsCreator;
use App\Ticket\Get\Send\TicketHDEAddSend;
use App\Ticket\Get\Send\TicketHDEGetSend;
use App\Ticket\Post\RequestCreator\TicketAddRequestCreator;

final class TicketManager extends AbstractManager
{
    public function allGetRequestsCreator(): AllGetRequestsCreatorInterface
    {
        return $this->container->get(TicketAllGetRequestsCreator::class);
    }

    public function getSend(): GetHDESendInterface
    {
        return $this->container->get(TicketHDEGetSend::class);
    }

    public function idsFromGetResponse(): IdsFromGetResponseInterface
    {
        return new BaseIdsFromGetResponse();
    }

    public function getDeleteRequestCreator(): DeleteRequestCreatorInterface
    {
        return new TicketDeleteRequestCreator();
    }

    public function reflector(): ReflectorInterface
    {
        return $this->container->get(TicketReflector::class);
    }

    public function cache(): AbstractCache
    {
        return $this->container->get('cache.ticket');
    }

    public function addRequestCreator(): AddRequestCreatorInterface
    {
        return $this->container->get(TicketAddRequestCreator::class);
    }

    public function addSend(): HDEAddSendInterface
    {
        return $this->container->get(TicketHDEAddSend::class);
    }
}
