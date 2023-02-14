<?php

declare(strict_types=1);

namespace App\Repository\Assistant;

use App\Connection\ConnectionInterface;
use App\DTO\Diabetes\Assistant\Assistant;
use App\Repository\Configuration\SaveRepository as ConfigurationSaveRepository;
use App\Repository\Input\SaveRepository as InputSaveRepository;
use App\Repository\Output\SaveRepository as OutputSaveRepository;
use Doctrine\DBAL\Exception;

class SaveRepository
{
    public function __construct(
        private readonly ConnectionInterface $connection,
        private readonly OutputSaveRepository $outputSaveRepository,
        private readonly ConfigurationSaveRepository $configurationSaveRepository,
        private readonly InputSaveRepository $inputSaveRepository,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke(Assistant $assistant): void
    {
        ($this->outputSaveRepository)($assistant->output);
        ($this->configurationSaveRepository)($assistant->configuration);
        ($this->inputSaveRepository)($assistant->input);

        $statement = $this->connection->prepare($assistant->saveQuery());
        $statement->executeQuery($assistant->save());
        $assistant->setId((int)$this->connection->lastInsertId());
    }
}
