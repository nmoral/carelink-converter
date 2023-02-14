<?php

declare(strict_types=1);

namespace App\CareLink\File\Reader;

class RowCompiler
{
    public function __invoke(array $rows): array
    {
        if (1 === count($rows)) {
            return $rows[0];
        }
        $compiledRow = [];
        foreach ($rows as $row) {
            foreach ($row as $index => $value) {
                if (isset($value) && !empty($value)) {
                    $compiledRow[$index] = $value;
                    continue;
                }

                if (!isset($compiledRow[$index])) {
                    $compiledRow[$index] = null;
                }
            }
        }

        return $compiledRow;
    }
}
