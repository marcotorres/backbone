<?php

namespace App\Http\Controllers\ZipCode;

use App\Http\Controllers\Controller;
use App\Http\Requests\ZipCode;
use Symfony\Component\HttpFoundation\JsonResponse;

class ZipCodeController extends Controller
{
    /**
     * show request
     * @author Marco Torres, <mtorresa@uni.pe>
     * @param ZipCode\ZipCodeShowRequest $request
     * @return JsonResponse
     */
    public function show(ZipCode\ZipCodeShowRequest $request): JsonResponse
    {
        return $request->response();
    }
}
