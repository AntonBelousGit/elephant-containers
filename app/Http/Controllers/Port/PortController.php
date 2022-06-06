<?php

namespace App\Http\Controllers\Port;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class PortController extends Controller
{

    const PORTS = '/files/ports/ports.json';

    /**
     * Handle the incoming request.
     *
     * @return JsonResponse|array
     */
    public function getPort()
    {
        $isExists = file_exists(storage_path() . self::PORTS);

        if ($isExists) {
            return json_decode(file_get_contents(storage_path() .  self::PORTS), true);
        }

        return response()->json([
            'status' => 'Error',
            'message' => 'File not found',
        ], 404);
    }
}
