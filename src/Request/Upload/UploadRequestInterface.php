<?php

declare(strict_types=1);

namespace App\Request\Upload;

interface UploadRequestInterface
{
    public function getFileName(): string;
}
