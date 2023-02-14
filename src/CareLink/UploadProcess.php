<?php

declare(strict_types=1);

namespace App\CareLink;

use App\CareLink\Factory\Upload\UploadFactory;
use App\CareLink\File\Reader\UploadFileReader;
use App\DTO\Upload\Upload;
use App\Repository\Upload\SaveRepository;
use App\Request\Upload\UploadRequestInterface;
use Doctrine\DBAL\Driver\Exception;

class UploadProcess
{
    private Upload $upload;

    private RowProcessor $processor;

    public function __construct(
        private readonly SaveRepository $saveRepository,
    ) {
        $uploadFactory = new UploadFactory();
        $this->upload = $uploadFactory();
        $this->processor = new RowProcessor($this->upload);
    }

    /**
     * @throws Exception
     */
    public function __invoke(UploadRequestInterface $request): Upload
    {
        $fileReader = new UploadFileReader();
        $input = $fileReader($request);

        $endingBolus = [];
        foreach ($input as $item) {
            $this->handleRow($item, $endingBolus);
        }
        ($this->saveRepository)($this->upload);

        return $this->upload;
    }

    private function handleRow(mixed $item, array &$endingBolus): void
    {
        ($this->processor)($item, $endingBolus);
    }
}
