<?php

declare(strict_types=1);

namespace App\DTO\Diabetes;

use App\DTO\Entity;
use App\DTO\SavableEntity;
use App\DTO\Upload\Upload;

class Basal implements Entity, SavableEntity
{
    private ?int $id = null;
    public function __construct(
        public readonly \DateTimeInterface $date,
        public readonly \DateTimeInterface $time,
        public readonly float $amount,
        public readonly ?Alarm $alarm,
        public readonly Upload $upload,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function save(): array
    {
        return [
            $this->upload->getId(),
            $this->alarm?->getId(),
            $this->date->format('Y-m-d'),
            $this->time->format('H:i:s'),
            $this->amount,
            $this->amount,
        ];
    }

    public function saveQuery(): string
    {
        return 'INSERT INTO basal (id, upload, alarm, date, time, amount) VALUES (null, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE amount = ?';
    }
}
