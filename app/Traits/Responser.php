<?php
namespace App\Traits;

use Validator;

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

	public function formValidation($data, $rules)
	{
		$validation = Validator::make($data, $rules);

		if ($validation->fails()) {
			$response = [
				'error' 	=> 'Bad Request',
				'message'	=> implode(",", $validation->errors()->all())
			];
			
			response()->json($response, 400)->send();
			dd();
		}
	}
}