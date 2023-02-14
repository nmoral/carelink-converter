<?php

declare(strict_types=1);

namespace App\DTO\Diabetes;

use App\DTO\Diabetes\Assistant\Assistant;
use App\DTO\Entity;
use App\DTO\SavableEntity;
use App\DTO\Upload\Upload;

class Bolus implements Entity, SavableEntity
{
    private ?int $id = null;

    public function __construct(
        public readonly \DateTimeInterface $date,
        public readonly \DateTimeInterface $time,
        public readonly string $type,
        public readonly float $amount,
        public readonly float $delivered,
        public readonly Assistant $assistant,
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
            $this->assistant->getId(),
            $this->date->format('Y-m-d'),
            $this->time->format('H:i:s'),
            $this->type,
            $this->amount,
            $this->delivered,
            $this->type,
            $this->amount,
            $this->delivered,
        ];
    }

    public function saveQuery(): string
    {
        return 'INSERT INTO bolus (id, upload, assistant, date, time, type, amount, delivered) VALUES (null, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE type = ?, amount = ?, delivered = ?';
    }
}
