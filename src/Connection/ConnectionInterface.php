<?php

declare(strict_types=1);

namespace App\Connection;

use Doctrine\DBAL\Statement;

interface ConnectionInterface
{
    public function prepare(string $sql): Statement;

    public function lastInsertId($name = null): int;

    public function beginTransaction(): bool;

    public function commit(): bool;
}
