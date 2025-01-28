<?php

declare(strict_types=1);

namespace App\Common\Delete\Service;

use App\Common\Delete\RequestCreator\DeleteRequestCreatorInterface;
use App\Common\Get\GetDTO;
use App\Common\Service\Send\FulfilledAsyncService;
use GuzzleHttp\ClientInterface;

use function array_chunk;
use function array_map;

final class DeleteService
{
    /**
     * @param GetDTO[] $DTOs
     */
    public function delete(
        ClientInterface $client,
        DeleteRequestCreatorInterface $creator,
        array $DTOs,
        int $chunkSize = 50
    ): void {
        $requests = array_map(static fn (GetDTO $DTO) => $creator->deleteRequest($DTO), $DTOs);
        foreach (array_chunk($requests, $chunkSize) as $chunkRequests) {
            FulfilledAsyncService::send($client, $chunkRequests);
        }
    }
}
