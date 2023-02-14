<?php

declare(strict_types=1);

namespace App\CareLink\Factory\Diabetes\Assistant;

use App\DTO\Diabetes\Assistant\Input as DTO;
use App\Utils\Number\CleanNumber;

class Input
{
    private readonly CleanNumber $cleanNumber;

    public function __construct()
    {
        $this->cleanNumber = new CleanNumber();
    }

    public function __invoke(array $row): ?DTO
    {
        return new DTO(
            (int)($this->cleanNumber)($row[25]),
            (int)($this->cleanNumber)($row[26])
        );
    }
}
