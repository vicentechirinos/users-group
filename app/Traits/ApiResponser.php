<?php 

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection as CollectionQueryBuilder;

trait ApiResponser{

	private function successResponse($data, $code){
		return response()->json(['data'=>$data], $code);
	}

	protected function messageResponse($message, $code){
		return response()->json(['message'=>$message,'code'=>$code], $code);
	}

	protected function showOne(Model $data, $code=200){
		return $this->successResponse($data, $code);
	}

	protected function showAll(Collection $data, $code=200){
		return $this->successResponse($data, $code);
	}

	protected function showAllQueryBuilder(CollectionQueryBuilder $data, $code=200){
		return $this->successResponse($data, $code);
	}

}
