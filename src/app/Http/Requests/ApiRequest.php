<?php

namespace App\Http\Requests;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class ApiRequest extends FormRequest
{
    use ApiResponse;

    /**
     * get context
     *
     * @author Marco Torres, <mtorresa@uni.pe>
     * @return string
     */
    public function getContext(): string
    {
        return strtolower($this->method()) . ': ' . $this->getRequestUri();
    }

    /**
     * failed validation
     *
     * @author Marco Torres, <mtorresa@uni.pe>
     * @param Validator $validator     *
     * @return void
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new ValidationException($validator, $this->errorResponse());
    }

    /**
     * rules default
     *
     * @author Marco Torres, <mtorresa@uni.pe>
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * Get all inputs, files and params for the request.
     *
     * @author Marco Torres, <mtorresa@uni.pe>
     * @param  array  $keys
     * @return array
     */
    public function all($keys = null): array
    {
        $input = array_replace_recursive($this->input(), $this->allFiles());

        if (is_object($this->route()) && ($paramsRoute = $this->route()->parameters())) {
            $input = array_merge($paramsRoute, $input);
        }

        if (! $keys) {
            return $input;
        }

        $results = [];

        foreach (is_array($keys) ? $keys : func_get_args() as $key) {
            Arr::set($results, $key, Arr::get($input, $key));
        }

        return $results;
    }

    /**
     * errorResponse default
     *
     * @author Marco Torres, <mtorresa@uni.pe>
     * @return JsonResponse|null
     */
    protected function errorResponse(): ?JsonResponse
    {
        return response()->json([
            'apiVersion' => $this->getApiVersion(),
            'context' =>  $this->getContext(),
            'error' => [
                'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'message' => 'Los datos proporcionados no son válidos.',
                'errors' => $this->validator->errors()->messages()
            ]
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}
