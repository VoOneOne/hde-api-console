<?php

declare(strict_types=1);

namespace App\Common\Get;

use App\Common\Response\HDEResponse;
use Exception;

final class HDEGetResponse extends HDEResponse
{
    /**
     * @return GetDTO[]
     */
    public function getDTOs(): array
    {
        $DTOs = [];
        foreach ($this->data['data'] as $data) {
            $DTOs[$data['id']] = self::createDTO($data);
        }
        return $DTOs;
    }

    private function createDTO(array $data): GetDTO
    {
        throw new Exception('Unimplemented');
    }
}
