<?php

declare(strict_types=1);

namespace App\Common\Command;

use App\Common\Delete\RequestCreator\DeleteRequestCreatorInterface;
use App\Common\Delete\Service\DeleteService;
use App\Common\Factory\AbstractManager;
use App\Common\Factory\ClientManager;
use App\Common\Get\HDEGetResponse;
use App\Common\Get\RequestCreator\AllGetRequestsCreatorInterface;
use App\Common\Get\Send\GetHDESendInterface;
use App\Common\Service\Send\SendChunks;
use GuzzleHttp\ClientInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function array_map;
use function array_merge;

final class DeleteCommand extends Command
{
    private const CHUNKS_LENGTH = 40;
    private ClientInterface $destClient;
    private AllGetRequestsCreatorInterface $getCreator;
    private GetHDESendInterface $getSend;

    private DeleteRequestCreatorInterface $deleteRequestCreator;

    public function __construct(
        private DeleteService $deleteService,
        ClientManager $clientManager,
        AbstractManager $manager,
    ) {
        $this->destClient = $clientManager->dest();
        $this->getCreator = $manager->allGetRequestsCreator();
        $this->getSend = $manager->getSend();
        $this->deleteRequestCreator = $manager->getDeleteRequestCreator();

        parent::__construct(null);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $getRequests = $this->getCreator->getRequests($this->destClient);
        /**
         * @var HDEGetResponse[] $responses
         */
        $responses = SendChunks::send(
            $this->destClient,
            $this->getSend,
            $getRequests,
            self::CHUNKS_LENGTH,
        );
        $getDTOs = array_merge(
            ...array_map(
                static fn (HDEGetResponse $getResponse) => $getResponse->getDTOs(),
                $responses
            )
        );
        $this->deleteService->delete(
            $this->destClient,
            $this->deleteRequestCreator,
            $getDTOs,
            self::CHUNKS_LENGTH
        );

        return Command::SUCCESS;
    }
}
