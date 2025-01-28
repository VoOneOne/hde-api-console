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
use App\TicketComment\Common\TicketCommentReflector;
use App\TicketComment\Delete\RequestCreator\TicketCommentDeleteRequestCreator;
use App\TicketComment\Get\RequestCreator\TicketCommentAllGetRequestsCreator;
use App\TicketComment\Get\Send\TicketCommentHDEAddSend;
use App\TicketComment\Get\Send\TicketCommentHDEGetSend;
use App\TicketComment\Post\RequestCreator\TicketCommentAddRequestCreator;

final class TicketCommentManager extends AbstractManager
{
    public function allGetRequestsCreator(): AllGetRequestsCreatorInterface
    {
        return $this->container->get(TicketCommentAllGetRequestsCreator::class);
    }

    public function getSend(): GetHDESendInterface
    {
        return $this->container->get(TicketCommentHDEGetSend::class);
    }

    public function idsFromGetResponse(): IdsFromGetResponseInterface
    {
        return $this->container->get(BaseIdsFromGetResponse::class);
    }

    public function getDeleteRequestCreator(): DeleteRequestCreatorInterface
    {
        return new TicketCommentDeleteRequestCreator();
    }

    public function reflector(): ReflectorInterface
    {
        return $this->container->get(TicketCommentReflector::class);
    }

    public function cache(): CacheInterface
    {
        return new NullCache();
    }

    public function addRequestCreator(): AddRequestCreatorInterface
    {
        return $this->container->get(TicketCommentAddRequestCreator::class);
    }

    public function addSend(): HDEAddSendInterface
    {
        return $this->container->get(TicketCommentHDEAddSend::class);
    }
}
