<?php

declare(strict_types=1);

use App\Common\Command\DeleteCommand;
use App\Common\Command\LoadCommand;
use App\Common\Delete\Service\DeleteService;
use App\Common\Factory\ClientManager;
use App\Common\Factory\UserManager;
use App\Common\Service\Reflector\AbstractCache;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Container\ContainerInterface;

return [
    'cache.user' => static fn (ContainerInterface $container) => new AbstractCache(
        $container->get(CacheItemPoolInterface::class),
        'user_data_mirror_'
    ),
    'command.delete.user' => static fn (ContainerInterface $container) => new DeleteCommand(
        $container->get(DeleteService::class),
        $container->get(ClientManager::class),
        $container->get(UserManager::class),
    ),
    'command.load.user' => static fn (ContainerInterface $container) => new LoadCommand(
        $container->get(ClientManager::class),
        $container->get(UserManager::class),
    ),
];
