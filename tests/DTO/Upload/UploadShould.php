<?php

declare(strict_types=1);

namespace App\Tests\DTO\Upload;

use App\DTO\Collection;
use App\DTO\Upload\Upload;
use PHPUnit\Framework\TestCase;

class UploadShould extends TestCase
{
    public function testSaveQuery(): void
    {
        $upload = new Upload(new Collection(), new Collection(), new Collection(), new Collection(), new Collection());
        self::assertEquals('INSERT INTO upload(id, date) VALUES (null, ?)', $upload->saveQuery());
    }
}
