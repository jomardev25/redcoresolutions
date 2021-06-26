<?php

namespace App\Traits;

trait ApiTraits
{
    public function successResponse($data, $message = 'success', $statusCode = 200)
	{
		return response()->json([
			'message' => $message, 
			'data' => $data,
            'status' => $statusCode
		], $statusCode);
	}

	public function vueTableResponse(array $data, $message = 'success', $statusCode = 200)
	{
        $data['message'] = $message;
        $data['status'] = $statusCode;

		return response()->json($data, $statusCode);	
	}

	protected function errorResponse($response = [], $message = 'error', $statusCode = null)
	{
        if(!is_null($message))
            $response['message'] = $message;

		if(!is_null($statusCode))
            $response['status'] = $statusCode;

        $response['data'] = null;
		return response()->json($response, $statusCode);
	}
}