<?php

declare(strict_types=1);

namespace App\Common\Post\RequestCreator;

use App\Common\Post\AddDTO;
use Psr\Http\Message\RequestInterface;

interface AddRequestCreatorInterface
{
    public function postRequest(AddDTO $dto): RequestInterface;
}
