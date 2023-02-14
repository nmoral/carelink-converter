<?php

declare(strict_types=1);

namespace App\CareLink\Factory\Diabetes;

use App\CareLink\Factory\Diabetes\Assistant\Assistant;
use App\DTO\Upload\Upload;
use App\DTO\Diabetes\Bolus as DTO;
use App\Utils\Number\CleanNumber;
use DateTimeImmutable;

class BolusFactory
{
    private readonly CleanNumber $cleanNumber;

    private readonly Assistant $assistant;

    public function __construct(
        private readonly Upload $upload,
    ) {
        $this->cleanNumber = new CleanNumber();
        $this->assistant = new Assistant();
    }

    public function __invoke(array $row): ?DTO
    {
        return new DTO(
            DateTimeImmutable::createFromFormat('Y/m/d', $row[1]),
            DateTimeImmutable::createFromFormat('H:i:s', $row[2]),
            $row[11],
            ($this->cleanNumber)($row[12]),
            ($this->cleanNumber)($row[13]),
            ($this->assistant)($row),
            $this->upload,
        );
    }
}
