<?php namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Psr\Log\LoggerInterface;
use Monolog\Handler\HipChatHandler;

class Handler extends ExceptionHandler
{


    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        'Symfony\Component\HttpKernel\Exception\HttpException'
    ];

    /**
     * Create a new exception handler instance.
     *
     * @param  LoggerInterface $log
     */
    public function __construct(LoggerInterface $log)
    {
        $hipchatConfig = \Config::get('services.hipchat');
        $hipchatHandler = new HipChatHandler(
            $hipchatConfig['token'],
            $hipchatConfig['room'],
            $hipchatConfig['name'],
            false,
            $hipchatConfig['level']
        );

        \Log::getMonolog()->pushHandler($hipchatHandler);

        parent::__construct($log);
    }

    /**
     * Report or log an exception.
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     *
     * @return void
     */
    public function report(\Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $e
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request, \Exception $e)
    {
        return parent::render($request, $e);
    }
}
