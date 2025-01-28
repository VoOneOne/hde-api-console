<?php

declare(strict_types=1);

use App\Common\Command\DeleteCommand;
use App\Common\Command\LoadCommand;
use App\Common\Delete\Service\DeleteService;
use App\Common\Factory\ClientManager;
use App\Common\Factory\TicketManager;
use App\Common\Service\Reflector\AbstractCache;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Container\ContainerInterface;

return [
    'cache.ticket' => static fn (ContainerInterface $container) => new AbstractCache(
        $container->get(CacheItemPoolInterface::class),
        'ticket_data_mirror_'
    ),
    'command.delete.ticket' => static fn (ContainerInterface $container) => new DeleteCommand(
        $container->get(DeleteService::class),
        $container->get(ClientManager::class),
        $container->get(TicketManager::class),
    ),
    'command.load.ticket' => static fn (ContainerInterface $container) => new LoadCommand(
        $container->get(ClientManager::class),
        $container->get(TicketManager::class),
    ),
];
