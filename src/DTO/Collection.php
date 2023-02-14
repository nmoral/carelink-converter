<?php

declare(strict_types=1);

namespace App\DTO;

use ArrayAccess;
use Countable;
use Iterator;
use Traversable;

class Collection implements Countable, ArrayAccess, Iterator
{
    private int $index;

    public function __construct(
        /** @var array<Entity> */
        private array $data = []
    ) {
        $this->rewind();
    }

    public function add(Entity $object): static
    {
        $this->data[] = $object;

        return $this;
    }

    public function count(): int
    {
        return count($this->data);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet(mixed $offset): ?Entity
    {
        return $this->data[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->data[] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->data[$offset]);
    }

    public function current(): Entity
    {
        return $this->data[$this->index];
    }

    public function next(): void
    {
        ++$this->index;
    }

    public function key(): int
    {
        return $this->index;
    }

    public function valid(): bool
    {
        return $this->offsetExists($this->key());
    }

    public function rewind(): void
    {
        $this->index = 0;
    }
}
