<?php

declare(strict_types=1);

namespace App\CareLink\Factory\Diabetes\Assistant;

use App\DTO\Diabetes\Assistant\Output as DTO;
use App\Utils\Number\CleanNumber;

class Output
{
    private readonly CleanNumber $cleanNumber;

    public function __construct()
    {
        $this->cleanNumber = new CleanNumber();
    }

    public function __invoke(array $row): ?DTO
    {
        return new DTO(
            (float)($this->cleanNumber)($row[20]),
            (float)($this->cleanNumber)($row[28]),
            (float)($this->cleanNumber)($row[27])
        );
    }
}
