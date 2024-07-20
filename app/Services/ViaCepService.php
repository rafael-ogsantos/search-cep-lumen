<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ViaCepService
{
    protected $baseUrl = 'https://viacep.com.br/ws/';

    public function buscarCep($cep)
    {
        $cacheKey = "cep-{$cep}";

        $result = Cache::get($cacheKey);

        if (!$result) {
            $result = $this->consultaViaCep($cep);

            Cache::put($cacheKey, $result, 60);
        }

        return $result;
    }

    protected function consultaViaCep($cep)
    {
        $response = Http::get("{$this->baseUrl}{$cep}/json/");
        return $response->json();
    }
}
