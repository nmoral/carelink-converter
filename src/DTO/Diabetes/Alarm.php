<?php

declare(strict_types=1);

namespace App\DTO\Diabetes;

use App\DTO\Entity;
use App\DTO\SavableEntity;
use App\DTO\Upload\Upload;

class Alarm implements Entity, SavableEntity
{
    private ?int $id = null;

    public function __construct(
        public readonly \DateTimeInterface $date,
        public readonly \DateTimeInterface $time,
        public readonly string $cause,
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
            $this->cause,
            $this->cause,
        ];
    }

    public function saveQuery(): string
    {
        return 'INSERT INTO alarm(id, upload, date, time, cause) VALUES (null, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE cause = ?';
    }
}
