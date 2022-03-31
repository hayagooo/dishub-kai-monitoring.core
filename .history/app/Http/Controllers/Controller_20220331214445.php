<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function jsonResponse(mixed $payload = null, int $status = 200, string $statusText = 'SUCCESS'): JsonResponse
    {
        return new JsonResponse([
            'status' => $statusText,
            'payload' => $payload,
        ], $status);
    }

    public function checkDirectory()
    {
        if(!File::isDirectory(public_path('/monitoring/icon/'))) {
            File::makeDirectory(public_path('/monitoring/icon'), 0777, true, true);
        }
    }
}
