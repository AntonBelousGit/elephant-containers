<?php

namespace App\Http\Controllers\Carrier;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class CarrierController extends Controller
{
    const JSONCARRIER = '/files/carriers/carrier-json.json';
    const XMLCARRIER = '/files/carriers/carrier-xml.xml';

    /**
     *
     * @return JsonResponse|array
     */
    public function getJsonCarrier()
    {
        $isExists = file_exists(storage_path() . self::JSONCARRIER);

        if ($isExists) {
            return json_decode(file_get_contents(storage_path() . self::JSONCARRIER), true);
        }

        return response()->json([
            'status' => 'Error',
            'message' => 'File not found',
        ], 404);
    }

    public function getXmlCarrier()
    {
        $isExists = file_exists(storage_path() . self::XMLCARRIER);

        if ($isExists) {
            $xmlDataString = file_get_contents(storage_path() . self::XMLCARRIER);
            $xmlObject = simplexml_load_string($xmlDataString);
            $json = json_encode($xmlObject);
            $port = json_decode($json, true);
            return $port['route'];
        }

        return response()->json([
            'status' => 'Error',
            'message' => 'File not found',
        ], 404);
    }
}
