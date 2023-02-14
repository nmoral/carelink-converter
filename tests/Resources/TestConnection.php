<?php

declare(strict_types=1);

namespace App\Tests\Resources;

use App\Connection\ConnectionInterface;
use Doctrine\DBAL\Driver\Result;
use Doctrine\DBAL\Statement;
use Doctrine\DBAL\ParameterType;
use PHPUnit\Framework\Assert;

/**
 * @method object getNativeConnection()
 */
class TestConnection implements ConnectionInterface
{
    /**
     * @var true
     */
    private bool $executed = false;

    public function __construct()
    {
    }

    public function assertExecuted()
    {
        Assert::assertTrue($this->executed);
    }

    public function exec()
    {
        $this->executed = true;
    }

    public function prepare(string $sql): Statement
    {
        return new TestStatement($this);
    }


    public function lastInsertId($name = null): int
    {
        return 0;
    }

    public function beginTransaction(): bool
    {
        return true;
    }

    public function commit(): bool
    {
        return true;
    }
}
