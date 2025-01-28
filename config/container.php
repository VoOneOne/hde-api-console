<?php

declare(strict_types=1);

$builder = new DI\ContainerBuilder();
$builder->addDefinitions(require __DIR__ . '/dependencies.php');
$builder->useAttributes(true);
$builder->useAutowiring(true);
return $builder->build();
