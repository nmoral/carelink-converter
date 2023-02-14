<?php

declare(strict_types=1);

namespace App\CareLink\Factory\Diabetes;

use App\DTO\Upload\Upload;
use App\DTO\Diabetes\Alarm as DTO;
use DateTimeImmutable;

class AlarmFactory
{
    public function __construct(
        private readonly Upload $upload,
    ) {
    }

    public function __invoke(array $row): ?DTO
    {
        return empty($row[17]) ? null : new DTO(
            DateTimeImmutable::createFromFormat('Y/m/d', $row[1]),
            DateTimeImmutable::createFromFormat('H:i:s', $row[2]),
            $row[17],
            $this->upload,
        );
    }
}
