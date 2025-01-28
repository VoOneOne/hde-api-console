<?php

declare(strict_types=1);

namespace App\Common\Factory;

use App\Common\Post\RequestCreator\AddRequestCreatorInterface;
use App\Common\Post\Send\HDEAddSendInterface;
use App\Common\Service\Reflector\AbstractCache;
use App\Common\Service\Reflector\ReflectorInterface;
use App\User\Common\UserReflector;
use App\User\Delete\RequestCreator\UserDeleteRequestCreator;
use App\User\Get\RequestCreator\UserAllGetRequestsCreator;
use App\User\Get\RequestCreator\UserIdsFromGetResponse;
use App\User\Get\Send\UserHDEAddSend;
use App\User\Get\Send\UserHDEGetSend;
use App\User\Post\RequestCreator\UserAddRequestCreator;

final class UserManager extends AbstractManager
{
    public function allGetRequestsCreator(): UserAllGetRequestsCreator
    {
        return $this->container->get(UserAllGetRequestsCreator::class);
    }

    public function getSend(): UserHDEGetSend
    {
        return $this->container->get(UserHDEGetSend::class);
    }

    public function idsFromGetResponse(): UserIdsFromGetResponse
    {
        return new UserIdsFromGetResponse();
    }

    public function getDeleteRequestCreator(): UserDeleteRequestCreator
    {
        return $this->container->get(UserDeleteRequestCreator::class);
    }

    public function reflector(): ReflectorInterface
    {
        return new UserReflector();
    }

    public function addRequestCreator(): AddRequestCreatorInterface
    {
        return new UserAddRequestCreator();
    }

    public function addSend(): HDEAddSendInterface
    {
        return $this->container->get(UserHDEAddSend::class);
    }

    public function cache(): AbstractCache
    {
        return $this->container->get('cache.user');
    }
}
