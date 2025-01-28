<?php

declare(strict_types=1);

namespace App\Common\Factory;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Psr\Container\ContainerInterface;

final class ClientManager
{
    public function __construct(private ContainerInterface $container) {}

    public function src(): ClientInterface
    {
        return new Client([
            'base_uri' => $this->container->get('hde.src.address'),
            'auth' => [$this->container->get('hde.src.email'), $this->container->get('hde.src.password')],
            'handler' => $this->container->get('client.handler_stack'),
        ]);
    }

    public function dest(): ClientInterface
    {
        return new Client([
            'base_uri' => $this->container->get('hde.dest.address'),
            'auth' => [$this->container->get('hde.dest.email'), $this->container->get('hde.dest.password')],
            'handler' => $this->container->get('client.handler_stack'),
        ]);
    }
}
