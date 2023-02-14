<?php

declare(strict_types=1);

namespace App\Repository\Bolus;

use App\Connection\ConnectionInterface;
use App\DTO\Diabetes\Bolus;
use App\Repository\Assistant\SaveRepository as AssistantSaveRepository;
use Doctrine\DBAL\Exception;

class SaveRepository
{
    public function __construct(
        private readonly ConnectionInterface $connection,
        private readonly AssistantSaveRepository $assistantSaveRepository,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke(Bolus $bolus): void
    {
        ($this->assistantSaveRepository)($bolus->assistant);
        $statement = $this->connection->prepare($bolus->saveQuery());
        $statement->executeQuery($bolus->save());
        $bolus->setId($this->connection->lastInsertId());
    }
}
