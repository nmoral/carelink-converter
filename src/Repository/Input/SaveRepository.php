<?php

declare(strict_types=1);

namespace App\Repository\Input;

use App\Connection\ConnectionInterface;
use App\DTO\Diabetes\Assistant\Input;
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
    public function __invoke(Input $input): void
    {
        $statement = $this->connection->prepare($input->saveQuery());
        $statement->executeQuery($input->save());
        $input->setId($this->connection->lastInsertId());
    }
}
