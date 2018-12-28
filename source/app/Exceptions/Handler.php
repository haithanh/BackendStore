<?php

namespace App\Exceptions;

use App\Jobs\SendEmail;
use App\Mail\ExceptionOccured;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Debug\Exception\FlattenException;

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
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $exception
     *
     * @return void
     */
    public function report(Exception $exception)
    {
        if (env("APP_URL") != "http://localhost")
        {
            if ($this->shouldReport($exception))
            {
                $this->sendEmail($exception); // sends an email
            }
        }

        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $exception
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }

    public function sendEmail(Exception $exception)
    {
        try
        {
            $e = FlattenException::create($exception);

            $handler = new \Symfony\Component\Debug\ExceptionHandler();

            $html = $handler->getHtml($e);
            dispatch(new SendEmail(MAIL_TYPE_ERROR_EXCEPTION, "haint@gclub.vn", array("content" => $html)));
        }
        catch (Exception $ex)
        {
            dd($ex);
        }
    }
}
