<?php

declare(strict_types=1);

namespace App\repository;

use PDO;

final class UserRepository
{
    public function __construct(private readonly PDO $database)
    {

    }
}