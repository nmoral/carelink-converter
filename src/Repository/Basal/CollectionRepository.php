<?php

declare(strict_types=1);

namespace App\Repository\Basal;

use App\DTO\Collection;
use Doctrine\DBAL\Driver\Exception;

class CollectionRepository
{
    public function __construct(
        private readonly SaveRepository $saveRepository
    )
    {
    }

    /**
     * @throws Exception
     */
    public function __invoke(Collection $collection): void
    {
        foreach ($collection as $sensor) {
            ($this->saveRepository)($sensor);
        }
    }
}
