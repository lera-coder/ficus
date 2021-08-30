<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{
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
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->reportable(function (TransactionFailedException $exception){
            return response()->json('This operation was stopped', 500);
        });


    }

    public function render($request, Throwable $e)
    {
        if ($e instanceof UsedTechnologyTypeInKnowledgesException) {
            return response()->json($e->getMessage(), 405);
        }

        else if($e instanceof TransactionFailedException){
            return response()->json('This operation was stopped', 500);
        }

        else if($e instanceof WorkerNotInThisCompanyException){
            return response()->json('Worker is not in this company', 405);
        }

        else if($e instanceof InvalidNetworkConnectException){
            return response()->json('Invalid network connection!', 404);
        }

        return parent::render($request, $e);
    }
}
