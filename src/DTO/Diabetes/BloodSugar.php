<?php

declare(strict_types=1);

namespace App\DTO\Diabetes;

use App\DTO\Entity;
use App\DTO\SavableEntity;
use App\DTO\Upload\Upload;

class BloodSugar implements Entity, SavableEntity
{
    private ?int $id = null;
    public function __construct(
        public readonly \DateTimeInterface $date,
        public readonly \DateTimeInterface $time,
        public readonly string $type,
        public readonly int $value,
        public readonly Upload $upload,
    )
    {
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
            $this->type,
            $this->value,
            $this->type,
            $this->value,
        ];
    }

    public function saveQuery(): string
    {
        return 'INSERT INTO bloodSugar (id, upload, date, time, type, value) VALUES (null, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE type = ?, value = ?';
    }
}
