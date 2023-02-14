<?php

declare(strict_types=1);

namespace App\Connection;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Statement;

/**
 * @codeCoverageIgnore
 */
class MainConnection implements ConnectionInterface
{
    private Connection $connection;

    public function __construct(
        string $dbName,
        string $dbUsername,
        string $dbPassword,
        string $dbHost,
    ) {
        $this->connection = DriverManager::getConnection([
            'dbname'   => $dbName,
            'user'     => $dbUsername,
            'password' => $dbPassword,
            'host'     => $dbHost,
            'driver'   => 'pdo_mysql',
        ]);

//        $this->connection->setAutoCommit(false);
    }

    public function prepare(string $sql): Statement
    {
        return $this->connection->prepare($sql);
    }

    public function lastInsertId($name = null): int
    {
        return (int)$this->connection->lastInsertId($name);
    }

    /**
     * @throws Exception
     */
    public function beginTransaction(): bool
    {
        return $this->connection->beginTransaction();
    }

    /**
     * @throws Exception
     */
    public function commit(): bool
    {
        return $this->connection->commit();
    }

    protected function getConnection(): Connection
    {
        return $this->connection;
    }

}
