<?php

declare(strict_types=1);

use App\Common\Command\DeleteCommand;
use App\Common\Command\LoadCommand;
use App\Common\Delete\Service\DeleteService;
use App\Common\Factory\ClientManager;
use App\Common\Factory\TicketPostManager;
use Psr\Container\ContainerInterface;

return [
    'command.delete.ticket-post' => static fn (ContainerInterface $container) => new DeleteCommand(
        $container->get(DeleteService::class),
        $container->get(ClientManager::class),
        $container->get(TicketPostManager::class),
    ),
    'command.load.ticket-post' => static fn (ContainerInterface $container) => new LoadCommand(
        $container->get(ClientManager::class),
        $container->get(TicketPostManager::class),
    ),
];
