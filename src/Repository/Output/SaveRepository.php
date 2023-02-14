<?php

declare(strict_types=1);

namespace App\Repository\Output;

use App\Connection\ConnectionInterface;
use App\DTO\Diabetes\Assistant\Output;
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
    public function __invoke(Output $output): void
    {
        $statement = $this->connection->prepare($output->saveQuery());
        $statement->executeQuery($output->save());
        $output->setId($this->connection->lastInsertId());
    }
}
