<?php

namespace App\Exceptions;

use App\Traits\ApiTraits;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    use ApiTraits;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [

    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        "password",
        "password_confirmation",
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
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
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($request->wantsJson() && !config("app.debug")) {  //add Accept: application/json in request header
            return $this->handleApiException($request, $exception);
        }
        return parent::render($request, $exception);
    }

    private function handleApiException($request, Exception $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            $response = [
                "status" => Response::HTTP_NOT_FOUND,
                "error" => "Entry for ".str_replace("App\\", "", $exception->getModel())." not found."
            ];

            return $this->errorResponse($response, "Not Found", Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof \Spatie\Permission\Exceptions\UnauthorizedException) {
            $response = [
                "status" => Response::HTTP_FORBIDDEN,
                "error" => "Access is denied. You don't have permission to view this directory or page."
            ];

            return $this->errorResponse($response, "Unauthorized", Response::HTTP_FORBIDDEN);
        }

        $exception = $this->prepareException($exception);

        if ($exception instanceof HttpResponseException) {
            $exception = $exception->getResponse();
        }

        if ($exception instanceof AuthenticationException) {
            $exception = $this->unauthenticated($request, $exception);
        }

        if ($exception instanceof ValidationException) {
            $exception = $this->convertValidationExceptionToResponse($exception, $request);
        }

        return $this->customApiResponse($exception);
    }

    private function customApiResponse($exception)
    {
        if (method_exists($exception, "getStatusCode")) {
            $statusCode = $exception->getStatusCode();
        } else {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        $response = [];

        switch ($statusCode) {
            case Response::HTTP_UNAUTHORIZED: //401
                $response["message"] = __("error.401");
                break;
            case Response::HTTP_FORBIDDEN: //403
                $response["message"] = __("error.403");
                break;
            case Response::HTTP_NOT_FOUND: //404
                $response["message"] = __("error.404");
                break;
            case Response::HTTP_METHOD_NOT_ALLOWED: //405
                $response["message"] = __("error.405");
                break;
            case Response::HTTP_UNPROCESSABLE_ENTITY:
                $response["message"] = $exception->original["message"];
                $response["errors"] = $exception->original["errors"];
                break;
            default:
                $response["message"] = ($statusCode == 500) ? __("error.500") : $exception->getMessage();
                break;
        }

        $response["status"] = $statusCode;
        return $this->errorResponse($response, null, $statusCode);
    }
}
