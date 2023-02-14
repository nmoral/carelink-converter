<?php

declare(strict_types=1);

namespace App\Repository\Basal;

use App\Connection\ConnectionInterface;
use App\DTO\Diabetes\Basal;
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
    public function __invoke(Basal $bolus): void
    {
        $statement = $this->connection->prepare($bolus->saveQuery());
        $statement->executeQuery($bolus->save());
        $bolus->setId($this->connection->lastInsertId());
    }
}
