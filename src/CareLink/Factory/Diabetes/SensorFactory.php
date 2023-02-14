<?php

declare(strict_types=1);

namespace App\CareLink\Factory\Diabetes;

use App\DTO\Diabetes\Sensor as DTO;
use App\DTO\Upload\Upload;
use DateTimeImmutable;

class SensorFactory
{
    public function __construct(
        private readonly Upload $upload,
    ) {
    }

    public function __invoke(array $row): DTO
    {
        return new DTO(
            DateTimeImmutable::createFromFormat('Y/m/d', $row[1]),
            DateTimeImmutable::createFromFormat('H:i:s', $row[2]),
            (int)$row[32],
            (float)$row[33],
            $this->upload,
        );
    }
}
