<?php

declare(strict_types=1);

namespace App\DTO;

interface SavableEntity
{
    public function getId(): ?int;

    public function setId(int $id): void;

    public function save(): array;

    public function saveQuery(): string;
}
