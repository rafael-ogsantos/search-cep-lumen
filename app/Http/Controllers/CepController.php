<?php

namespace App\Http\Controllers;

use App\Services\CepProcessorService;
use Illuminate\Http\Request;
use App\Services\ViaCepService;
use Laravel\Lumen\Routing\Controller as BaseController;

class CepController extends BaseController
{
    protected $viaCepService;
    protected $cepProcessorService;

    public function __construct(ViaCepService $viaCepService, CepProcessorService $cepProcessorService)
    {
        $this->viaCepService = $viaCepService;
        $this->cepProcessorService = $cepProcessorService;
    }

    public function searchLocal($ceps)
    {
        $response = $this->cepProcessorService->processCeps($ceps);

        return response()->json($response);
    }
}
