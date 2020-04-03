<<<<<<< HEAD
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
=======
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
>>>>>>> 2311e5b979cc5d8ba99b72a66491d8d933e45f74
