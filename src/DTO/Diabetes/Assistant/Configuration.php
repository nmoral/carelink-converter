<?php

declare(strict_types=1);

namespace App\DTO\Diabetes\Assistant;

use App\DTO\Entity;
use App\DTO\SavableEntity;

class Configuration implements Entity, SavableEntity
{
    private ?int $id = null;

    public function __construct(
        public readonly int $bloodSugarTargetHigh,
        public readonly int $bloodSugarTargetLow,
        public readonly float $carbsRatio,
        public readonly int $insulinSensibility,
        public readonly float $activeInsulin,
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
            $this->bloodSugarTargetHigh,
            $this->bloodSugarTargetLow,
            $this->carbsRatio,
            $this->insulinSensibility,
            $this->activeInsulin,
        ];
    }

    public function saveQuery(): string
    {
        return 'INSERT INTO configuration (id, bloodSugarTargetHigh, bloodSugarTargetLow, carbsRatio, insulinSensibility, activeInsulin) VALUES (null, ?, ?, ?, ?, ?)';
    }
}
