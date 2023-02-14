<?php

declare(strict_types=1);

namespace App\Repository\BloodSugar;

use App\Connection\ConnectionInterface;
use App\DTO\Diabetes\BloodSugar;
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
    public function __invoke(BloodSugar $bolus): void
    {
        $statement = $this->connection->prepare($bolus->saveQuery());
        $statement->executeQuery($bolus->save());
        $bolus->setId($this->connection->lastInsertId());
    }
}
