<?php

declare(strict_types=1);

namespace App\Tests\Action\Upload;

use App\Action\Upload\UploadAction;
use App\Repository\Assistant\CleanRepository;
use App\Repository\Bolus\CollectionRepository;
use App\Repository\Bolus\SaveRepository;
use App\Repository\Sensor\CollectionRepository as SensorCollectionRepository;
use App\Repository\Sensor\SaveRepository as SensorSaveRepository;
use App\Repository\Upload\SaveRepository as UploadSaveRepository;
use App\Request\Upload\UploadRequestInterface;
use App\Tests\Resources\TestConnection;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @test
 */
class UploadActionShould extends TestCase
{
    /**
     * @test
     * @throws Exception
     */
    public function importData(): void
    {
        $uploadConnectionTest = new TestConnection();
        $sensorConnectionTest = new TestConnection();
        $bolusConnectionTest = new TestConnection();
        $assistantConnectionTest = new TestConnection();

        $action = new UploadAction();
        $request = $this->createMock(UploadRequestInterface::class);
        $request->method('getFileName')->willReturn(__DIR__.'/../../ressources/Carelink.csv');
        $response = $action(
            $request,
            new UploadSaveRepository(
                $uploadConnectionTest,
                new SensorCollectionRepository(new SensorSaveRepository($sensorConnectionTest)),
                new CollectionRepository(
                    new SaveRepository(
                        $bolusConnectionTest,
                        new \App\Repository\Assistant\SaveRepository(
                            $assistantConnectionTest,
                            new \App\Repository\Output\SaveRepository(new TestConnection()),
                            new \App\Repository\Configuration\SaveRepository(new TestConnection()),
                            new \App\Repository\Input\SaveRepository(new TestConnection()),
                        ),
                    ),
                ),
                new \App\Repository\Alarm\CollectionRepository(new \App\Repository\Alarm\SaveRepository(new TestConnection())),
                new \App\Repository\Basal\CollectionRepository(new \App\Repository\Basal\SaveRepository(new TestConnection())),
                new \App\Repository\BloodSugar\CollectionRepository(new \App\Repository\BloodSugar\SaveRepository(new TestConnection())),
                new CleanRepository(new TestConnection()),
            ),
        );

        self::assertInstanceOf(JsonResponse::class, $response);
        $data = json_decode($response->getContent(), true);
        self::assertEquals(957, $data['content']['totalSensor']);
        self::assertEquals(153, $data['content']['totalBasal']);
        self::assertEquals(40, $data['content']['totalBolus']);
        self::assertEquals(44, $data['content']['totalAlert']);
        self::assertEquals(42, $data['content']['totalBloodSugar']);
        $uploadConnectionTest->assertExecuted();
        $sensorConnectionTest->assertExecuted();
        $bolusConnectionTest->assertExecuted();
        $assistantConnectionTest->assertExecuted();
    }
}
