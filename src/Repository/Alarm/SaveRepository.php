<?php

declare(strict_types=1);

namespace App\Repository\Alarm;

use App\Connection\ConnectionInterface;
use App\DTO\Diabetes\Alarm;
use Doctrine\DBAL\Exception;

class SaveRepository
{
    public function __construct(
        private readonly ConnectionInterface $connection,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke(Alarm $alarm): void
    {
        $statement = $this->connection->prepare($alarm->saveQuery());
        $statement->executeQuery($alarm->save());
        $alarm->setId($this->connection->lastInsertId());
    }
}
