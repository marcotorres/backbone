<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * send failed response
     *
     * @author Marco Torres, <mtorresa@uni.pe>
     * @param string $msg
     * @param int $code
     *
     * @return JsonResponse
     */
    protected function sendFailedResponse(string $msg = '', int $code = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        $message = __($msg);
        if (empty($message)) {
            Log::error('Mensaje sin Traducción: ' . $msg);
            app()->setLocale('en');
            $message = __($msg);
        }

        return response()->json([
            'apiVersion' => config('backbone.api_version'),
            'error' => $message ?: __('An internal error has occurred, please try again later.')
        ], $code);
    }

    /**
     * send success response
     *
     * @author Marco Torres, <mtorresa@uni.pe>
     * @param mixed $msg
     * @param array $body
     * @param int $status
     *
     * @return JsonResponse
     */
    protected function sendSuccessResponse(mixed $msg, array $body = [], int $status = Response::HTTP_OK): JsonResponse
    {
        $data = [
            'apiVersion' => config('backbone.api_version'),
        ];

        if (is_array($msg)) {
            $data['data'] = array_merge($msg, $body);
        } elseif (is_string($msg)) {
            $data['data']['message'] = $msg;

            if ($body) {
                $data['data'] = array_merge($data['data'], $body);
            }
        }

        return response()->json($data, $status);
    }
}
