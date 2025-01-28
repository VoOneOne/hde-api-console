<?php


use App\Common\Command\TestCommand;
use App\Common\ErrorHandler;
use DI\Container;
use Symfony\Component\Console\Application;

require __DIR__ . '/bootstrap.php';

/**
 * @var Container $container
 */
$container = require __DIR__ . '/config/container.php';
$application = new Application();
$errorHandler = $container->get(ErrorHandler::class);
$errorHandler->register();

$application->add($container->get(TestCommand::class)->setName('test'));

$application->add($container->get('command.delete.user')->setName('user:delete'));
$application->add($container->get('command.load.user')->setName('user:load'));

$application->add($container->get('command.delete.ticket')->setName('ticket:delete'));
$application->add($container->get('command.load.ticket')->setName('ticket:load'));

$application->add($container->get('command.delete.ticket-post')->setName('ticket-post:delete'));
$application->add($container->get('command.load.ticket-post')->setName('ticket-post:load'));

$application->add($container->get('command.delete.ticket-comment')->setName('ticket-comment:delete'));
$application->add($container->get('command.load.ticket-comment')->setName('ticket-comment:load'));

$application->run();

