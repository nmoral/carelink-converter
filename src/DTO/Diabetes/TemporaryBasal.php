<?php

declare(strict_types=1);

namespace App\DTO\Diabetes;

use App\DTO\Upload\Upload;

class TemporaryBasal extends Basal
{
    public function __construct(
        \DateTimeInterface $date,
        \DateTimeInterface $time,
        float $amount,
        ?Alarm $alarm,
        Upload $upload,
        public readonly ?int $temporaryBasalAmount = null,
        public readonly ?string $temporaryBasalType = null,
        public readonly ?\DateTimeInterface $endTemporaryBasal = null,
    ) {
        parent::__construct($date, $time, $amount, $alarm, $upload);
    }

    public function save(): array
    {
        return [
            $this->upload->getId(),
            $this->alarm?->getId(),
            $this->date->format('Y-m-d'),
            $this->time->format('H:i:s'),
            $this->amount,
            $this->temporaryBasalAmount,
            $this->temporaryBasalType,
            $this->endTemporaryBasal->format(\DateTimeInterface::RFC3339),
            $this->amount,
            $this->temporaryBasalAmount,
            $this->temporaryBasalType,
            $this->endTemporaryBasal->format(\DateTimeInterface::RFC3339),
        ];
    }

    public function saveQuery(): string
    {
        return 'INSERT INTO basal (id, upload, alarm, date, time, amount, temporaryBasalAmount, temporaryBasalType, endTemporaryBasal) VALUES (null, ?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE amount = ?, temporaryBasalAmount = ?, temporaryBasalType = ?, endTemporaryBasal = ?';
    }
}
