<?php


use App\Common\ErrorHandler;
use App\Common\Service\AsyncRequestSenderWithRetry;
use App\Common\Service\RequestSenderInterface;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\RedisAdapter;

return [
    StreamHandler::class => new StreamHandler(__DIR__ . '../../../log/request.log', Level::Debug),
    LoggerInterface::class => function (ContainerInterface $container) {
        $logger = new Logger('RequestLogger');
        $logger->pushHandler($container->get(StreamHandler::class));
        return $logger;
    },
    'client.log_middleware' => function (ContainerInterface $container) {
        return Middleware::log(
            $container->get(LoggerInterface::class),
            new MessageFormatter('{req_headers}'),
        );
    },
    'client.rate_limit_middleware' => function (ContainerInterface $container) {
        return Middleware::mapResponse(function ($response) use ($container) {

            $rateLimitRemaining = (int)$response->getHeaderLine('X-Rate-Limit-Remaining');
            print_r($rateLimitRemaining);
            if ($rateLimitRemaining !== 0 && $rateLimitRemaining <= ($line = 15)) {
                $container->get(LoggerInterface::class)->warning('Rate limit exceeded. Pausing for 60 seconds.');
                sleep(60);
            }
            return $response;
        });
    },
    'client.handler_stack' => function (ContainerInterface $container) {
        $handlerStack = HandlerStack::create();
        $handlerStack->push($container->get('client.log_middleware'));
        $handlerStack->push($container->get('client.rate_limit_middleware'));
        return $handlerStack;
    },
    Redis::class => function () {
        $redis = new Redis();
        $redis->connect('127.0.0.1');
        return $redis;
    },
    CacheItemPoolInterface::class => function (ContainerInterface $container) {
        return new RedisAdapter($container->get(Redis::class));
    },
    RequestSenderInterface::class => function (ContainerInterface $container) {
        return $container->get(AsyncRequestSenderWithRetry::class);
    },
    ErrorHandler::class => function (ContainerInterface $container) {
        return new ErrorHandler(
            $container->get(LoggerInterface::class)
        );
    }
];
