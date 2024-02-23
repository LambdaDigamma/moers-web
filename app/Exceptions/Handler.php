<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use LaravelJsonApi\Core\Exceptions\JsonApiException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        JsonApiException::class,
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->renderable(
            \LaravelJsonApi\Exceptions\ExceptionParser::make()->renderable()
        );
    }

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
     * @param Exception $exception
     * @return void
     * @throws Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @param Exception $exception
     * @return Response
     */
    public function render($request, Throwable $exception)
    {

        if ($exception instanceof ModelNotFoundException && $request->wantsJson()) {
            return response()->json([
                'error' => 'Entry for ' . str_replace('App\\', '', $exception->getModel()) . ' not found'
            ], 404);
        }

        return parent::render($request, $exception);
    }
}
