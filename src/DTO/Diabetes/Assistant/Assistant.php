<?php

declare(strict_types=1);

namespace App\DTO\Diabetes\Assistant;

use App\DTO\Diabetes\Bolus;
use App\DTO\Entity;
use App\DTO\SavableEntity;

class Assistant implements Entity, SavableEntity
{
    private ?int $id = null;

    public function __construct(
        public readonly Output $output,
        public readonly Configuration $configuration,
        public readonly Input $input,
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
            $this->output->getId(),
            $this->configuration->getId(),
            $this->input->getId(),
        ];
    }

    public function saveQuery(): string
    {
        return 'INSERT INTO assistant (id, output, configuration, input) VALUES (null, ?, ?, ?)';
    }
}
