<?php

declare(strict_types=1);

namespace App\User\Get\Service;

use App\Common\Common\GetResponseToAddRequestInterface;
use Exception;

use function array_map;

final class GetResponseToAddRequest implements GetResponseToAddRequestInterface
{
    public function createAddRequests(array $getResponses): array
    {
        $users = $this->getUsersWithIdKey($getResponses);
        $addUsers = array_map(
            [$this, 'userToAddUser'],
            $users
        );
        return $this->createAddUserRequests($addUsers);
    }

    public function userToAddUser(array $user): array
    {
        return [
            'name' => $user['name'] ?? throw new Exception('Ожидалось name в userData'),
            'email' => $user['email'] ?? throw new Exception('Ожидалось email в userData'),
            'department' => [1],
            'group_id' => $user['group_id'] ?? 1,
            'password' => '123456789',
        ];
    }

    public function createAddUserRequests(array $users): array
    {
        return array_map(
            static fn ($user) => [
                'method' => 'POST',
                'uri' => 'users/',
                'options' => [
                    'form_params' => [
                        'name' => $user['name'],
                        'email' => $user['email'],
                        'password' => '123456789',
                        'department' => [1],
                        'group_id' => $user['group_id'] ?? 1,
                    ],
                ],
            ],
            $users
        );
    }

    private function getUsersWithIdKey(array $fulfilledResponse): array
    {
        $users = [];
        foreach ($fulfilledResponse as $responseData) {
            $data = $this->responseToArray($responseData['value']);
            foreach ($data['data'] as $user) {
                if ($user['id'] === 1 || $user['id'] === 2) {
                    continue;
                }
                $users[(int)$user['id']] = $user;
            }
        }
        return $users;
    }
}
