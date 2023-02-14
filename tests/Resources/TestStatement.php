<?php

declare(strict_types=1);

namespace App\Tests\Resources;

use Doctrine\DBAL\Result;
use Doctrine\DBAL\Statement;
use Doctrine\DBAL\ParameterType;

class TestStatement extends Statement
{
    public function __construct(
        private readonly TestConnection $connection
    ) {
    }

    public function bindValue($param, $value, $type = ParameterType::STRING)
    {
    }

    public function bindParam($param, &$variable, $type = ParameterType::STRING, $length = null)
    {
    }

    public function execute($params = null): Result
    {
        $this->connection->exec();

        return new TestResult();
    }
}
