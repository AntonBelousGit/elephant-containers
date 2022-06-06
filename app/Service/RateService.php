<?php


namespace App\Service;


use Carbon\Carbon;

class RateService
{

    public function makeEvaluation($state1, $state2, $count, $carrier): array
    {
        $calculateJson = [];
        $calculateXml = [];

        $dataJson = $carrier->getJsonCarrier();
        $searchJson = $this->search($dataJson, strtolower($state1), strtolower($state2), array('origin', 'destination', 'max_date'));

        $dataXml = $carrier->getXmlCarrier();
        $searchXml = $this->search($dataXml, $state1, $state2, array('origin_port', 'destination_port', 'expiration_date'));

        if ($searchJson) {
            $calculateJson = $this->calculateJson($searchJson, $count, 'JSON', array('price_per_container', 'price_per_shipment'));
        }
        if ($searchXml) {
            $calculateXml = $this->calculateXml($searchXml, $count, 'XML', 'price_per_container');
        }

        $result = array_merge($calculateJson, $calculateXml);

        return $result;
    }


    private function search($data, $state1, $state2, $condition): array
    {
        return array_filter(
            $data,
            function ($item) use ($condition, $state1, $state2) {
                if ($item[$condition[0]] === $state1 && $item[$condition[1]] === $state2 && !$this->endDate($item[$condition[2]])) {
                    return $item;
                }
            }
        );
    }

    private function endDate($date): bool
    {
        return Carbon::parse($date)->isPast();
    }

    private function calculateJson($data, $count, $type, $condition)
    {
        foreach ($data as $key => $item) {
            $data[$key]['sum'] = ($item[$condition[0]] * $count) + $item[$condition[1]];
            $data[$key]['type'] = $type;
        }
        return $data;
    }

    private function calculateXml($data, $count, $type, $condition)
    {
        foreach ($data as $key => $item) {
            $data[$key]['sum'] = $item[$condition] * $count;
            $data[$key]['type'] = $type;
        }
        return $data;
    }
}
