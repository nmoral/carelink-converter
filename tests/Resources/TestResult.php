<?php

declare(strict_types=1);

namespace App\Tests\Resources;

use Doctrine\DBAL\Result;

class TestResult extends Result
{
    public function __construct()
    {
    }

    public function fetchNumeric()
    {
        // TODO: Implement fetchNumeric() method.
    }

    public function fetchAssociative()
    {
        // TODO: Implement fetchAssociative() method.
    }

    public function fetchOne()
    {
        // TODO: Implement fetchOne() method.
    }

    public function fetchAllNumeric(): array
    {
        return [];
    }

    public function fetchAllAssociative(): array
    {
        return [];
    }

    public function fetchFirstColumn(): array
    {
        return [];
    }

    public function rowCount(): int
    {
        return 0;
    }

    public function columnCount(): int
    {
        return 0;
    }

    public function free(): void
    {
    }
}
