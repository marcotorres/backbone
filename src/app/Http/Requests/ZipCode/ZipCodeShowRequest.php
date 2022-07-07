<?php

namespace App\Http\Requests\ZipCode;

use App\Http\Requests\ApiRequest;
use App\Models\ZipCode;
use Illuminate\Http\JsonResponse;

class ZipCodeShowRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @author Marco Torres, <mtorresa@uni.pe>
     * @return array
     */
    public function rules(): array
    {
        return ZipCode::$showRules;
    }

    /**
     * messages
     * @author Marco Torres, <mtorresa@uni.pe>
     * @return array
     */
    public function messages(): array
    {
        return ZipCode::$messageRules;
    }

    /**
     * response
     * @author Marco Torres, <mtorresa@uni.pe>
     * @return JsonResponse
     */
    public function response(): JsonResponse
    {
        return response()->json(
            ZipCode::query()->with(['federalEntity', 'settlements', 'municipality'])->find($this->route('zipcode'))
        );
    }
}
