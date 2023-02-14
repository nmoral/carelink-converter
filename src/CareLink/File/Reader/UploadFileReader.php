<?php

declare(strict_types=1);

namespace App\CareLink\File\Reader;

use App\Request\Upload\UploadRequestInterface;

class UploadFileReader
{
    public function __invoke(UploadRequestInterface $request): array
    {
        $file = fopen($request->getFileName(), 'r');
        $index = 0;
        $input = [];
        while ($row = fgetcsv($file, separator: ';')) {
            ++$index;
            if ($index < 8 || empty($row[0]) || in_array($row[2], ['Sensor', 'Time'], true)) {
                continue;
            }

            $key = md5($row[1].$row[2]);
            if (!isset($input[$key])) {
                $input[$key] = [];
            }
            $input[$key][] = $row;
        }

        fclose($file);

        return $input;
    }
}
