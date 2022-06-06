<?php

namespace App\Http\Controllers\V2;

use App\Action\Port\CheckIssetPortAction;
use App\Http\Controllers\Carrier\CarrierController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Port\PortController;
use App\Http\Resources\CalculatingRatesResource;
use App\Service\RateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RatesController extends Controller
{

    protected $rateService;
    protected $port;
    protected $carrier;

    public function __construct(RateService $rateService)
    {
        $this->rateService = $rateService;
        $this->port = new PortController();
        $this->carrier = new CarrierController();
    }

    /**
     * Handle the incoming request.
     *
     * @param null $state1
     * @param null $state2
     * @param null $count
     * @return AnonymousResourceCollection|JsonResponse
     */

    public function __invoke(CheckIssetPortAction $action, $state1 = null, $state2 = null, $count = null)
    {
        if (is_null($state1) || is_null($state2) || is_null($count)) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Bad request, enter the correct data. STATE1,STATE2,COUNT',
            ], 400);
        }

        $status = $action->handle($this->port->getPort(), $state1, $state2);

        if (!$status) {
            return response()->json([
                'status' => 'Error',
                'message' => 'One of the specified ports is not in service. Sorry',
            ], 400);
        }

        $result = $this->rateService->makeEvaluation($state1, $state2, $count, $this->carrier);

        if (empty($result)) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Nothing found',
            ], 404);
        }

        return CalculatingRatesResource::collection($result);
    }
}
