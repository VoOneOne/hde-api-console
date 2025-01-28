<?php

declare(strict_types=1);

namespace App\Common;

use Psr\Log\LoggerInterface;
use Throwable;

final class ErrorHandler
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Инициализация обработчиков ошибок.
     */
    public function register(): void
    {
        set_error_handler([$this, 'handleError']);
        set_exception_handler([$this, 'handleException']);
        register_shutdown_function([$this, 'handleShutdown']);
    }

    /**
     * Обработка обычных ошибок (например, E_WARNING).
     */
    public function handleError(int $errno, string $errstr, string $errfile, int $errline): bool
    {
        $this->logger->error("PHP Error: [{$errno}] {$errstr} in {$errfile} on line {$errline}");

        // Возвращаем `false`, чтобы позволить стандартному обработчику ошибок PHP продолжить выполнение,
        // или `true`, чтобы подавить дальнейшую обработку.
        return true;
    }

    /**
     * Обработка исключений.
     */
    public function handleException(Throwable $exception): void
    {
        $this->logger->critical(
            'Uncaught Exception: ' . $exception->getMessage(),
            [
                'exception' => $exception,
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ]
        );

        // Вы можете вернуть пользовательский ответ, например:
        http_response_code(500);
        echo json_encode(['error' => 'Internal Server Error']);
        exit;
    }

    /**
     * Обработка фатальных ошибок.
     */
    public function handleShutdown(): void
    {
        $error = error_get_last();
        if ($error !== null) {
            $this->logger->emergency(
                "Fatal Error: {$error['message']} in {$error['file']} on line {$error['line']}"
            );

            // Вы можете вернуть пользовательский ответ, например:
            http_response_code(500);
            echo json_encode(['error' => 'Fatal Error']);
        }
    }
}
