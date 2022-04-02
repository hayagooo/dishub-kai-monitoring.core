<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

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

    public function checkDirectory(string $public_path)
    {
        if(!File::isDirectory(public_path($public_path))) {
            File::makeDirectory(public_path($public_path), 0777, true, true);
        }
    }
}
