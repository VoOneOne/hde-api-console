<?php

declare(strict_types=1);

use App\Common\Command\DeleteCommand;
use App\Common\Command\LoadCommand;
use App\Common\Delete\Service\DeleteService;
use App\Common\Factory\ClientManager;
use App\Common\Factory\TicketCommentManager;
use Psr\Container\ContainerInterface;

return [
    'command.delete.ticket-comment' => static fn (ContainerInterface $container) => new DeleteCommand(
        $container->get(DeleteService::class),
        $container->get(ClientManager::class),
        $container->get(TicketCommentManager::class),
    ),
    'command.load.ticket-comment' => static fn (ContainerInterface $container) => new LoadCommand(
        $container->get(ClientManager::class),
        $container->get(TicketCommentManager::class),
    ),
];
