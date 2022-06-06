<?php

namespace App\Http\Controllers\Port;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PortController extends Controller
{

    const PORTS = '/files/ports/ports.json';

    /**
     * Handle the incoming request.
     *
     * @return JsonResponse|array
     */
    public function __invoke()
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
