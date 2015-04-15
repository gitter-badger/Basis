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
        if ($request->ajax() or $request->wantsJson()) {
            $exceptionClass = get_class($e);
            $response = response()->json([
                'exception' => $exceptionClass,
                'message' => $e->getMessage()
            ]);

            //---------------------------------------------------------------------------------------
            // Since we have custom ValidationException class, only validation-related exceptions
            // should be listed here. Laravel handles exceptions correctly, status-code wise.
            //---------------------------------------------------------------------------------------

            switch ($exceptionClass) {
                case 'App\Exceptions\Common\ValidationException':
                case 'App\Exceptions\Users\LoginNotValidException':
                case 'App\Exceptions\Users\PasswordNotValidException':
                case 'Illuminate\Http\Exception\HttpResponseException':
                    $response = $response->setStatusCode(422);
                    break;
            }

            return $response;
        }

        return parent::render($request, $e);
    }
}
