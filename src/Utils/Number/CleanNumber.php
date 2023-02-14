<?php

declare(strict_types=1);

namespace App\Utils\Number;

class CleanNumber
{
    public function __invoke(?string $number): int|float
    {
        if (empty($number)) {
            return 0;
        }

        if (str_contains($number, ',')) {
            return (float)str_replace(',', '.', $number);
        }

        return (int)$number;
    }
}
