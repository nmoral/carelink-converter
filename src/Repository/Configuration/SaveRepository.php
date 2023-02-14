<?php

declare(strict_types=1);

namespace App\Repository\Configuration;

use App\Connection\ConnectionInterface;
use App\DTO\Diabetes\Assistant\Configuration;
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
    public function __invoke(Configuration $configuration): void
    {
        $statement = $this->connection->prepare($configuration->saveQuery());
        $statement->executeQuery($configuration->save());
        $configuration->setId($this->connection->lastInsertId());
    }
}
