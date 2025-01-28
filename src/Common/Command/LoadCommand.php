<?php

declare(strict_types=1);

namespace App\Common\Command;

use App\Common\Factory\AbstractManager;
use App\Common\Factory\ClientManager;
use App\Common\Get\RequestCreator\AllGetRequestsCreatorInterface;
use App\Common\Get\Send\GetHDESendInterface;
use App\Common\Post\AddHDEResponse;
use App\Common\Post\RequestCreator\AddRequestCreatorInterface;
use App\Common\Post\Send\HDEAddSendInterface;
use App\Common\Service\Reflector\CacheInterface;
use App\Common\Service\Reflector\ReflectorInterface;
use App\Common\Service\Send\SendChunks;
use Exception;
use GuzzleHttp\ClientInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function array_chunk;

final class LoadCommand extends Command
{
    public const REQUEST_CHUNK_SIZE = 30;
    public const LOOP_CHUNK_SIZE = 2;
    private GetHDESendInterface $getSend;
    private HDEAddSendInterface $addSend;
    private ClientInterface $srcClient;
    private ClientInterface $destClient;
    private ReflectorInterface $reflector;
    private AllGetRequestsCreatorInterface $allGetRequestsCreator;
    private AddRequestCreatorInterface $addRequestCreator;
    private CacheInterface $cache;

    public function __construct(
        ClientManager $clientManager,
        AbstractManager $abstractManager
    ) {
        $this->srcClient = $clientManager->src();
        $this->destClient = $clientManager->dest();
        $this->getSend = $abstractManager->getSend();
        $this->allGetRequestsCreator = $abstractManager->allGetRequestsCreator();
        $this->reflector = $abstractManager->reflector();
        $this->addRequestCreator = $abstractManager->addRequestCreator();
        $this->cache = $abstractManager->cache();
        $this->addSend = $abstractManager->addSend();
        parent::__construct(null);
    }

    public function executeChunk(array $getRequests): void
    {
        $getResponses = SendChunks::send(
            $this->srcClient,
            $this->getSend,
            $getRequests,
            self::REQUEST_CHUNK_SIZE
        );
        $addDTOs = $this->getAndReflect($getResponses);
        $addRequests = $this->createAddRequests($addDTOs);
        $addResponses = SendChunks::send(
            $this->destClient,
            $this->addSend,
            $addRequests,
            self::REQUEST_CHUNK_SIZE
        );
        /**
         * @var AddHDEResponse $addResponse
         */
        foreach ($addResponses as $srcDTOId => $addResponse) {
            $this->cache->setMirror($srcDTOId, $addResponse->getDTO()->getId());
        }
    }

    public function getAndReflect(array $getResponses): array
    {
        $addDTOs = [];
        foreach ($getResponses as $response) {
            foreach ($response->getDTOs() as $getDTO) {
                try {
                    $addDTOs[$getDTO->getId()] = $this->reflector->reflect($getDTO);
                } catch (Exception $e) {
                    continue;
                }
            }
        }
        return $addDTOs;
    }

    public function createAddRequests(array $addDTOs): array
    {
        $addRequests = [];
        foreach ($addDTOs as $srcDTOId => $addDTO) {
            $addRequests[$srcDTOId] = $this->addRequestCreator->postRequest($addDTO);
        }
        return $addRequests;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $getRequests = $this->allGetRequestsCreator->getRequests($this->srcClient);
        foreach (array_chunk($getRequests, self::LOOP_CHUNK_SIZE) as $chunkGetRequests) {
            $this->executeChunk($chunkGetRequests);
        }

        return Command::SUCCESS;
    }
}
