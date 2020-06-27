<?php
namespace App\Traits;

trait Responser {
	protected function successResponse($data, $message)
	{
		return response()->json(compact('message', 'data'));
	}

	protected function badRequest($message)
	{
        $response = [
            'error'     => 'Bad Request',
            'message'   => $message
        ];
        
        response()->json($response, 400)->send();
        dd();
	}
}