<?php

declare(strict_types=1);

namespace App\Action\Upload;

use App\CareLink\UploadProcess;
use App\Repository\Upload\SaveRepository;
use App\Request\Upload\UploadRequestInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UploadAction
{
    #[Route(path: '/carelink/upload', name: 'carelink_upload', methods: [Request::METHOD_POST])]
    public function __invoke(
        UploadRequestInterface $request,
        SaveRepository $saveRepository,
    ): JsonResponse {
        $uploadProcess = new UploadProcess($saveRepository);

        $upload = $uploadProcess($request);

        return new JsonResponse([
            'content' => [
                'totalSensor'     => count($upload->sensor),
                'totalBasal'      => count($upload->basal),
                'totalBolus'      => count($upload->boluses),
                'totalAlert'      => count($upload->alarms),
                'totalBloodSugar' => count($upload->bloodSugars),
            ],
        ]);
    }
}
