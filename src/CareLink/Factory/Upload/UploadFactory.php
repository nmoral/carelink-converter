<?php

declare(strict_types=1);

namespace App\CareLink\Factory\Upload;

use App\DTO\Collection;
use App\DTO\Upload\Upload as DTO;

class UploadFactory
{
    public function __construct()
    {
    }

    public function __invoke(): DTO
    {
        return new DTO(
            new Collection(),
            new Collection(),
            new Collection(),
            new Collection(),
            new Collection(),
        );
    }
}
