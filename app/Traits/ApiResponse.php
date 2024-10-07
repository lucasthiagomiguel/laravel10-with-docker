<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * Respond with no content if the data is empty, otherwise respond with the data.
     *
     * @param mixed $data
     * @param string $message
     * @param int $status
     * @return JsonResponse
     */
    protected function respondWithNoContent($data, $message = 'No content found.'): JsonResponse
    {

        if ($data instanceof \Illuminate\Support\Collection && $data->isEmpty()) {
            return response()->json(['message' => $message]);
        }


        if (is_array($data) && empty($data)) {
            return response()->json(['message' => $message]);
        }

       
        return response()->json($data, 200);
    }
}
