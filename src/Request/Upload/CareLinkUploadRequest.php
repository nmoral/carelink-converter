<?php

declare(strict_types=1);

namespace App\Request\Upload;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\FileBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @codeCoverageIgnore
 */
class CareLinkUploadRequest implements UploadRequestInterface
{
    public function __construct(
        private readonly RequestStack $requestStack,
    ) {
    }

    public function getFileName(): string
    {
        /** @var UploadedFile $file */
        $file = $this->files()->get('careLinkExport');

        return $file->getRealPath();
    }

    private function files(): FileBag
    {
        return $this->request()->files;
    }

    private function request(): ?Request
    {
        return $this->requestStack->getCurrentRequest();
    }
}
