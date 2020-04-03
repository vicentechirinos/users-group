<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {
        if($exception instanceof ValidationException)
            return $this->convertValidationExceptionToResponse($exception, $request);

        if($exception instanceof ModelNotFoundException){
            $model=class_basename($exception->getModel());
            return $this->messageResponse('No existe ninguna instancia del modelo ' . $model . ' con el id especificado.', 404);
        }

        if($exception instanceof AuthenticationException)
            return $this->messageResponse('Usuario no autenticado',401);

        if($exception instanceof NotFoundHttpException)
            return $this->messageResponse('No existe la URL especificada',404);

        if(config('app.debug'))
            return parent::render($request, $exception);
        

        return $this->messageResponse('Error de Servidor',500);
    }

    protected function convertValidationExceptionToResponse(ValidationException $exception, $request)
    {
        return response()->json([
            'message' => 'Error de validación.',
            'code'=>$exception->status,
            'errors' => $exception->errors(),
        ], $exception->status);
    }

}
