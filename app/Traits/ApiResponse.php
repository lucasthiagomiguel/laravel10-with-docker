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
        // Verifica se o dado é uma coleção e se está vazia ou se é null.
        if ($data instanceof \Illuminate\Support\Collection && $data->isEmpty()) {
            return response()->json(['message' => $message]);
        }

        // Se o dado é um array vazio ou null.
        if (is_array($data) && empty($data)) {
            return response()->json(['message' => $message]);
        }

        // Se houver dados, retorna com status 200 e o conteúdo.
        return response()->json($data, 200);
    }
}
