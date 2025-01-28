<?php

declare(strict_types=1);

namespace App\Common\Factory;

use App\Common\Delete\RequestCreator\DeleteRequestCreatorInterface;
use App\Common\Get\RequestCreator\AllGetRequestsCreatorInterface;
use App\Common\Get\RequestCreator\IdsFromGetResponseInterface;
use App\Common\Get\Send\GetHDESendInterface;
use App\Common\Post\RequestCreator\AddRequestCreatorInterface;
use App\Common\Post\Send\HDEAddSendInterface;
use App\Common\Service\Reflector\CacheInterface;
use App\Common\Service\Reflector\ReflectorInterface;
use Psr\Container\ContainerInterface;

abstract class AbstractManager
{
    public function __construct(protected ContainerInterface $container) {}

    abstract public function allGetRequestsCreator(): AllGetRequestsCreatorInterface;

    abstract public function getSend(): GetHDESendInterface;

    abstract public function idsFromGetResponse(): IdsFromGetResponseInterface;

    abstract public function getDeleteRequestCreator(): DeleteRequestCreatorInterface;

    abstract public function reflector(): ReflectorInterface;

    abstract public function cache(): CacheInterface;

    abstract public function addRequestCreator(): AddRequestCreatorInterface;

    abstract public function addSend(): HDEAddSendInterface;
}
