<?php

declare(strict_types=1);

namespace App\DTO\Diabetes\Assistant;

use App\DTO\Entity;
use App\DTO\SavableEntity;

class Input implements Entity, SavableEntity
{
    private ?int $id = null;

    public function __construct(
        public readonly int $carbs,
        public readonly int $bloodSugar,
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
            $this->carbs,
            $this->bloodSugar,
        ];
    }

    public function saveQuery(): string
    {
        return 'INSERT INTO input (id, carbs, bloodSugar) VALUES (null, ?, ?)';
    }
}
