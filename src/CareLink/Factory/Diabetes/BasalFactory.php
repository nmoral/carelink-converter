<?php

declare(strict_types=1);

namespace App\CareLink\Factory\Diabetes;

use App\DTO\Diabetes\TemporaryBasal;
use App\DTO\Upload\Upload;
use App\DTO\Diabetes\Basal as DTO;
use App\Utils\Number\CleanNumber;
use DateInterval;
use DateTimeImmutable;

class BasalFactory
{
    private readonly AlarmFactory $alarm;

    private readonly CleanNumber $cleanNumber;

    public function __construct(
        private readonly Upload $upload,
    ) {
        $this->alarm = new AlarmFactory($this->upload);
        $this->cleanNumber = new CleanNumber();
    }

    public function __invoke(array $row): ?DTO
    {
        $alarm = ($this->alarm)($row);
        if (!empty($row[10])) {
            $startDate = DateTimeImmutable::createFromFormat('Y/m/d H:i:s', $row[1].' '.$row[2]);
            $interval = new DateInterval(sprintf('PT%dH%dM%dS', ...explode(':', $row[10])));
            $endDate = $startDate->add($interval);

            return new TemporaryBasal(
                DateTimeImmutable::createFromFormat('Y/m/d', $row[1]),
                DateTimeImmutable::createFromFormat('H:i:s', $row[2]),
                ($this->cleanNumber)($row[7]),
                $alarm,
                $this->upload,
                (int)$row[8],
                $row[9],
                $endDate
            );
        }

        return new DTO(
            DateTimeImmutable::createFromFormat('Y/m/d', $row[1]),
            DateTimeImmutable::createFromFormat('H:i:s', $row[2]),
            ($this->cleanNumber)($row[7]),
            $alarm,
            $this->upload,
        );
    }
}
