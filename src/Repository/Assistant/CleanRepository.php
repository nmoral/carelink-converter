<?php

declare(strict_types=1);

namespace App\Repository\Assistant;

use App\Connection\ConnectionInterface;
use Doctrine\DBAL\Exception;

class CleanRepository
{
    public function __construct(
        private readonly ConnectionInterface $connection,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke(): void
    {
        $statement = $this->connection->prepare(<<<SQL
    DELETE a, i, o, c FROM assistant as a 
    LEFT JOIN bolus as b on a.id = b.assistant 
    INNER JOIN input as i on a.input = i.id
    INNER JOIN output as o on a.output = o.id
    INNER JOIN configuration as c on a.configuration = c.id
    WHERE b.id is null
SQL);
        $statement->executeQuery();
    }
}
