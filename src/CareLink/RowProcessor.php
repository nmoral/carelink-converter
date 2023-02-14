<?php

declare(strict_types=1);

namespace App\CareLink;

use App\CareLink\Factory\Diabetes\AlarmFactory;
use App\CareLink\Factory\Diabetes\BasalFactory;
use App\CareLink\Factory\Diabetes\BloodSugarFactory;
use App\CareLink\Factory\Diabetes\BolusFactory;
use App\CareLink\Factory\Diabetes\SensorFactory;
use App\CareLink\File\Reader\RowCompiler;
use App\DTO\Upload\Upload;

class RowProcessor
{

    private SensorFactory $sensorFactory;

    private AlarmFactory $alarmFactory;

    private BasalFactory $basalFactory;

    private BolusFactory $bolusFactory;

    private BloodSugarFactory $bloodSugarFactory;

    private RowCompiler $rowCompiler;

    public function __construct(
        private readonly Upload $upload,
    ) {
        $this->sensorFactory = new SensorFactory($this->upload);
        $this->alarmFactory = new AlarmFactory($this->upload);
        $this->basalFactory = new BasalFactory($this->upload);
        $this->bolusFactory = new BolusFactory($this->upload);
        $this->bloodSugarFactory = new BloodSugarFactory($this->upload);
        $this->rowCompiler = new RowCompiler();
    }
    public function __invoke(array $item, array &$endingBolus): void
    {
        $item = ($this->rowCompiler)($item);
        // sensor
        if (!empty($item[32])) {
            $this->upload->sensor->add(($this->sensorFactory)($item));

            return;
        }

        // basal
        if (!empty($item[7])) {
            $this->upload->basal->add(($this->basalFactory)($item));
        }
        // ending bolus
        if (!empty($item[11]) && !empty($item[13])) {
            $endingBolus = $item;
        }

        //bolus
        if (!empty($item[11]) && empty($item[13])) {
            $item = ($this->rowCompiler)([$item, $endingBolus]);
            $this->upload->boluses->add(($this->bolusFactory)($item));
            $endingBolus = [];
        }

        // alarm
        if (!empty($item[17]) && empty($item[7])) {
            $this->upload->alarms->add(($this->alarmFactory)($item));
        }
        // blood sugar
        if (!empty($item[5]) && !in_array($item[4], ['BG_SENT_FOR_CALIB', 'USER_ACCEPTED_REMOTE_BG'])) {
            $this->upload->bloodSugars->add(($this->bloodSugarFactory)($item));
        }
    }
}
