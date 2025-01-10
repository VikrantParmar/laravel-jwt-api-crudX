<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Responses\Api\ApiResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */

    public function render($request, Throwable $exception)
    {
        // Log the exception details for debugging
        \Log::error($exception->getMessage(), [
            'exception' => $exception,
            'request' => $request->all(),
        ]);
        // Define the HTTP status code
        $errorCode = $exception->getCode() === 0 ? Response::HTTP_INTERNAL_SERVER_ERROR : (int) $exception->getCode();
        // Initialize errors variable
        $errors = [];

        // Check if the exception is an instance of ValidationException
        if ($exception instanceof ValidationException) {
            // Access the errors() method for validation exceptions
            $errors = $exception->errors();
        } else {
            // Handle other types of exceptions (e.g., general server error, not found)
            $errors = [$exception->getMessage()];
        }
        #$errors = $exception->errors();
        $errorMsg = collect($errors)->flatten()->join("\n");
        // Check if the request is an API request
        if ($request->expectsJson() || $request->is('api/*')) {
            return $this->handleApiExceptions($exception, $errorMsg, $request, $errorCode);
        }

        // Handle web-based requests (admin, backend, etc.)
        return $this->handleWebExceptions($exception, $errorMsg, $errorCode, $request);
    }

    /**
     * Handle API exceptions and return a structured JSON response.
     *
     * @param Throwable $exception
     * @param string $errorMsg
     * @param $request
     * @param int $errorCode
     * @return \Illuminate\Http\JsonResponse
     */
    protected function handleApiExceptions(Throwable $exception, string $errorMsg, $request, int $errorCode)
    {

        // Handle specific API exceptions
        if ($exception instanceof QueryException) {
            \Log::error("Database error: " . $exception->getMessage());
            return ApiResponse::error(__('messages.database_error'), [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Handle ModelNotFoundException (when a model is not found in the database)
        if ($exception instanceof ModelNotFoundException) {
            \Log::error('Resource Not Found: ' . $exception->getMessage());
            return ApiResponse::error(__('messages.model_not_found'), [], Response::HTTP_NOT_FOUND);
        }

        // Handle syntax errors or other PHP exceptions
        if ($exception instanceof \ParseError || $exception instanceof \ErrorException) {
            \Log::error("Syntax error: " . $exception->getMessage());
            return ApiResponse::error(__('messages.something_went_wrong') . ' | ' . $errorMsg . ' Error:200', [], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Handle validation errors
        if ($exception instanceof ValidationException) {
            return ApiResponse::error($errorMsg, $exception->errors(), Response::HTTP_BAD_REQUEST);
        }

        // Default fallback for API errors
        \Log::error("Application error: " . $errorMsg);
        return ApiResponse::error($errorMsg, [], $errorCode);
    }

    /**
     * Handle web exceptions and return custom error views.
     *
     * @param Throwable $exception
     * @param string $errorMsg
     * @param int $errorCode
     * @param $request
     * @return \Illuminate\Http\Response
     */
    protected function handleWebExceptions(Throwable $exception, string $errorMsg, int $errorCode, $request)
    {
        // Determine the appropriate view for the error page
        $view = $request->is('admin/*') || $request->is('bb-backend/*')
            ? 'errors.admin.500'
            : 'errors.500';

        // Handle application errors for web requests
        return response()->view($view, [
            'errorCode' => $errorCode,
            'errorMessage' => $exception->getMessage() ?: 'An unexpected error occurred. Please try again later.',
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

}
