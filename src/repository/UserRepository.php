<?php

declare(strict_types=1);

namespace App\repository;

use App\Models\User;
use PDO;

final class UserRepository
{
    public function __construct(private readonly PDO $database)
    {

    }

    public function findAll(): array
    {
        $statement = $this->database->query(
            'SELECT id, email, password_hash, roles, created_at, updated_at
             FROM users
             ORDER BY created_at DESC',
        );
        $rows = $statement->fetchAll();

        return array_map(
            static fn (array $row): User => User::fromRow($row),
            $rows,
        );
    }
}