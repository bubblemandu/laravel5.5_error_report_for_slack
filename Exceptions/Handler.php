<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Notification;
use App\Notifications\SendNotification;

class Handler extends ExceptionHandler
{
    protected $dontReport = [

    ];

    protected $dontFlash = [

    ];

    public function report(Exception $exception)
    {
        $sendNotification = new SendNotification;
        $sendNotification->setMessage($exception->getMessage());
        Notification::route('slack', 'slackUrl')->notify($sendNotification);

        parent::report($exception);
    }

    public function render($request, Exception $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Not Found Page', 400]);
            }

            return redirect('/');
        }

        return parent::render($request, $exception);
    }
}