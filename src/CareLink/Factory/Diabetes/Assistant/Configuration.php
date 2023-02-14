<?php

declare(strict_types=1);

namespace App\CareLink\Factory\Diabetes\Assistant;

use App\DTO\Diabetes\Assistant\Configuration as DTO;
use App\Utils\Number\CleanNumber;

class Configuration
{
    private readonly CleanNumber $cleanNumber;

    public function __construct()
    {
        $this->cleanNumber = new CleanNumber();
    }

    public function __invoke(array $row): ?DTO
    {
        return new DTO(
            (int)($this->cleanNumber)($row[21]),
            (int)($this->cleanNumber)($row[22]),
            (float)($this->cleanNumber)($row[23]),
            (int)($this->cleanNumber)($row[24]),
            (float)($this->cleanNumber)($row[29]),
        );
    }
}
