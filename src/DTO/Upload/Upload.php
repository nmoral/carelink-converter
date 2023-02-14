<?php

declare(strict_types=1);

namespace App\DTO\Upload;

use App\DTO\Collection;
use App\DTO\SavableEntity;

class Upload implements SavableEntity
{
    private readonly \DateTimeInterface $date;

    private ?int $id = null;

    public function __construct(
        public readonly Collection $sensor,
        public readonly Collection $boluses,
        public readonly Collection $basal,
        public readonly Collection $alarms,
        public readonly Collection $bloodSugars,
        ?\DateTimeInterface $date = null,
    ) {
        if (null === $date) {
            $date = new \DateTimeImmutable();
        }

        $this->date = $date;
    }

    public function save(): array
    {
        return [
            $this->date->format(\DateTimeInterface::RFC3339),
        ];
    }

    public function saveQuery(): string
    {
        return 'INSERT INTO upload(id, date) VALUES (null, ?)';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
