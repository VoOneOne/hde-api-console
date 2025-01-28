<?php

declare(strict_types=1);

namespace App\Common\Post;

use App\Common\Get\GetDTO;
use App\Common\Response\HDEResponse;

abstract class AddHDEResponse extends HDEResponse
{
    abstract public function getDTO(): GetDTO;
}
