<?php

declare(strict_types=1);

namespace App\DTO\Diabetes\Assistant;

use App\DTO\Entity;
use App\DTO\SavableEntity;

class Output implements Entity, SavableEntity
{
    private ?int $id = null;

    public function __construct(
        public readonly float $insulin,
        public readonly float $carbsInsulin,
        public readonly float $correctiveInsulin
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
            $this->insulin,
            $this->carbsInsulin,
            $this->correctiveInsulin,
        ];
    }

    public function saveQuery(): string
    {
        return 'INSERT INTO output (id, insulin, carbsInsulin, correctiveInsulin) VALUES (null, ?, ?, ?)';
    }
}
