<?php

declare(strict_types=1);

namespace App\Repository\Sensor;

use App\Connection\ConnectionInterface;
use App\DTO\Diabetes\Sensor;
use Doctrine\DBAL\Exception;

class SaveRepository
{
    public function __construct(
        private readonly ConnectionInterface $connection,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(Sensor $sensor): void
    {
        $statement = $this->connection->prepare($sensor->saveQuery());
        $statement->executeQuery($sensor->save());
        $sensor->setId($this->connection->lastInsertId());
    }
}
