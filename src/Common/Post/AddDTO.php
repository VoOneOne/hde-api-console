<?php

declare(strict_types=1);

namespace App\Common\Post;

use function get_object_vars;
use function http_build_query;

abstract class AddDTO
{
    abstract public function getUri(): string;

    final public function getBodyParams(): string
    {
        return http_build_query(get_object_vars($this));
    }
}
