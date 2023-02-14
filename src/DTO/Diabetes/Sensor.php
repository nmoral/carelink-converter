<?php

declare(strict_types=1);

namespace App\DTO\Diabetes;

use App\DTO\Entity;
use App\DTO\SavableEntity;
use App\DTO\Upload\Upload;

class Sensor implements Entity, SavableEntity
{
    private ?int $id = null;

    public function __construct(
        public readonly \DateTimeInterface $date,
        public readonly \DateTimeInterface $time,
        public readonly int $sugarBlood,
        public readonly float $ISIGValue,
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
            $this->date->format('Y-m-d'),
            $this->time->format('H:i:s'),
            $this->sugarBlood,
            $this->ISIGValue,
            $this->sugarBlood,
            $this->ISIGValue,
        ];
    }

    public function saveQuery(): string
    {
        return 'INSERT INTO sensor(id, upload, date, time,sugarBlood, ISIGValue) VALUES (null, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE sugarBlood = ?, ISIGValue = ?';
    }
}
