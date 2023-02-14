<?php

declare(strict_types=1);

namespace App\CareLink\Factory\Diabetes;

use App\DTO\Diabetes\BloodSugar as DTO;
use App\DTO\Upload\Upload;
use App\Utils\Number\CleanNumber;
use DateTimeImmutable;

class BloodSugarFactory
{
    private readonly CleanNumber $cleanNumber;

    public function __construct(
        private readonly Upload $upload,
    ) {
        $this->cleanNumber = new CleanNumber();
    }

    public function __invoke(array $row): DTO
    {
        return new DTO(
            DateTimeImmutable::createFromFormat('Y/m/d', $row[1]),
            DateTimeImmutable::createFromFormat('H:i:s', $row[2]),
            $row[4],
            (int)($this->cleanNumber)($row[5]),
            $this->upload,
        );
    }
}
