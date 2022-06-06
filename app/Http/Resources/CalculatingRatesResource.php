<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CalculatingRatesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'carrier' => $this['type'],
            'total_price' => $this['sum'],
            'currency' => ($this['currency'] === "USD" || $this['currency'] === "$")? "USD" :$this['currency'],
        ];
    }
}
