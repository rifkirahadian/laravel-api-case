<?php
namespace App\Traits;

trait Responser {
	protected function successResponse($data, $message)
	{
		return response()->json(compact('message', 'data'))->send();
	}

	protected function badRequest($message)
	{
        $response = [
            'error'     => 'Bad Request',
            'message'   => $message
        ];
        
        return response()->json($response, 400);
	}
}