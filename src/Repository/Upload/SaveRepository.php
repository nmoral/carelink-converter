<?php

declare(strict_types=1);

namespace App\Repository\Upload;

use App\Connection\ConnectionInterface;
use App\DTO\Upload\Upload;
use App\Repository\Alarm\CollectionRepository as AlarmCollectionRepository;
use App\Repository\Assistant\CleanRepository;
use App\Repository\Basal\CollectionRepository as BasalCollectionRepository;
use App\Repository\BloodSugar\CollectionRepository as BloodSugarCollectionRepository;
use App\Repository\Bolus\CollectionRepository as BolusCollectionRepository;
use App\Repository\Sensor\CollectionRepository as SensorCollectionRepository;
use Doctrine\DBAL\Exception;

class SaveRepository
{
    public function __construct(
        private readonly ConnectionInterface $connection,
        private readonly SensorCollectionRepository $sensorCollectionRepository,
        private readonly BolusCollectionRepository $bolusCollectionRepository,
        private readonly AlarmCollectionRepository $alarmCollectionRepository,
        private readonly BasalCollectionRepository $basalCollectionRepository,
        private readonly BloodSugarCollectionRepository $bloodSugarCollectionRepository,
        private readonly CleanRepository $assistantCleanRepository,
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(Upload $upload): void
    {
        $this->connection->beginTransaction();
        $statement = $this->connection->prepare($upload->saveQuery());
        $statement->executeQuery($upload->save());
        $upload->setId($this->connection->lastInsertId());

        ($this->basalCollectionRepository)($upload->basal);
        ($this->sensorCollectionRepository)($upload->sensor);
        ($this->bolusCollectionRepository)($upload->boluses);
        ($this->alarmCollectionRepository)($upload->alarms);
        ($this->bloodSugarCollectionRepository)($upload->bloodSugars);
        ($this->assistantCleanRepository)();
        $this->connection->commit();
    }
}
