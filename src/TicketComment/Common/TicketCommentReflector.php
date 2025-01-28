<?php

declare(strict_types=1);

namespace App\TicketComment\Common;

use App\Common\Get\GetDTO;
use App\Common\Post\AddDTO;
use App\Common\Service\Reflector\AbstractCache;
use App\Common\Service\Reflector\ReflectorInterface;
use App\TicketComment\Post\TicketCommentAddDTO;
use DI\Attribute\Inject;
use Exception;

final class TicketCommentReflector implements ReflectorInterface
{
    /**
     * @return TicketCommentAddDTO
     */
    public function __construct(
        #[Inject(name: 'cache.user')]
        private AbstractCache $userCache,
        #[Inject(name: 'cache.ticket')]
        private AbstractCache $ticketCache,
    ) {}

    /**
     * @throws Exception
     */
    public function reflect(GetDTO $dto): AddDTO
    {
        /**
         * @var  TicketCommentAddDTO $dto
         */
        $reflectUserId = $this->userCache->getMirror($dto->user_id);
        if ($reflectUserId === null) {
            throw new Exception('Reflect user_id not found');
        }

        $reflectTicketId = $this->ticketCache->getMirror($dto->ticket_id);
        if ($reflectTicketId === null) {
            throw new Exception('Reflect ticket_id not found');
        }

        return new TicketCommentAddDTO(
            $reflectTicketId,
            $dto->text,
            $reflectUserId,
        );
    }
}
