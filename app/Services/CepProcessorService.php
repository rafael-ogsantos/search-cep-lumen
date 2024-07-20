<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class CepProcessorService
{
    protected $viaCepService;

    public function __construct(ViaCepService $viaCepService)
    {
        $this->viaCepService = $viaCepService;
    }

    public function processCeps($ceps)
    {
        $cepArray = explode(',', $ceps);
        $responses = [];

        foreach ($cepArray as $cep) {
            $cep = str_replace('-', '', trim($cep));

            $validator = Validator::make(['cep' => $cep], [
                'cep' => 'required|string|regex:/^[0-9]{8}$/',
            ]);

            if ($validator->fails()) {
                $responses[] = ['error' => "CEP inválido: $cep"];
                continue;
            }

            $response = $this->viaCepService->buscarCep(trim($cep));
            if (!$response) {
                $responses[] = ['error' => "CEP não encontrado: $cep"];
            }

            $responses[] = $response;
        }

        return $responses;
    }
}
