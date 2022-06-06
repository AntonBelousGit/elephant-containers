<?php


namespace App\Action\Port;

class CheckIssetPortAction
{
    public function handle(array $port, string $state1, string $state2): bool
    {
        $found_key = array_column($port, 'iso_code');
        $issetState1 = array_search($state1, $found_key);
        $issetState2 = array_search($state2, $found_key);

        if ($issetState1 !== false && $issetState2 !== false) {
            return true;
        }
        return false;
    }
}
