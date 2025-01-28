<?php

declare(strict_types=1);

namespace App\Common\Delete\RequestCreator;

use App\Common\Get\GetDTO;
use Psr\Http\Message\RequestInterface;

interface DeleteRequestCreatorInterface
{
    public function deleteRequest(GetDTO $getDTO): RequestInterface;
}
