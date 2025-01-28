<?php

declare(strict_types=1);

namespace App\Common\Service\Reflector;

use App\Common\Get\GetDTO;
use App\Common\Post\AddDTO;

interface ReflectorInterface
{
    public function reflect(GetDTO $dto): AddDTO;
}
