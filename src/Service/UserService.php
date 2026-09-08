<?php

declare(strict_types=1);

namespace App\Service;

use App\Models\User;

final class UserService
{
    public function create(array $input): User
    {
        $user = new User([
            'scenario' => 'create',
            'id' => bin2hex(random_bytes(16)),
            'email' => $input['email'] ?? null,
            'roles' => ['ROLE_USER'],
        ]);
        $user->setPassword((string) ($input['password'] ?? ''));

        if (!$user->validate()) {
            return $user;
        }

        $user->save(false);

        return $user;
    }
}