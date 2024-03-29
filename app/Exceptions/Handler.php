<?php

namespace App\Exceptions;

use App\Notifications\ExceptionNotification;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
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

        });
    }
    public function render($request, Throwable $e)
    {
        Log::info($e->getMessage(). ' '.$e->getLine());
        if ($e instanceof QueryException) {
            if ($e->errorInfo[1] == 1451) {
                $notify[] = ['error', 'Cannot delete the item. It is related to other tables.'];
            } else {
                $notify[] = ['error', 'An error occurred with database query. Please try again later.'];
            }
            return redirect()->back()->withNotify($notify);;
        }
        return parent::render($request, $e);
    }
}
