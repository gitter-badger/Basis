<?php namespace App\Http\Controllers\Users;

use App\Contracts\Registrar;
use App\Exceptions\Users\TokenNotValidException;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PasswordController extends Controller
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Registrar service instance.
     *
     * @var Registrar
     */
    protected $registrar;

    /**
     * The password broker implementation.
     *
     * @var PasswordBroker
     */
    protected $passwords;

    /**
     * Request instance.
     *
     * @var Request
     */
    protected $request;

    /**
     * Create a new password controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard          $auth
     * @param  Registrar                                 $registrar
     * @param  \Illuminate\Contracts\Auth\PasswordBroker $passwords
     */
    public function __construct(Guard $auth, Registrar $registrar, PasswordBroker $passwords)
    {
        $this->auth = $auth;
        $this->registrar = $registrar;
        $this->request = \Route::getCurrentRequest();
        $this->passwords = $passwords;

        $this->middleware('guest');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Response
     */
    public function getEmail()
    {
        if ($this->request->ajax() || $this->request->wantsJson()) {
            return [];
        }

        return view('password/email');
    }

    /**
     * Send a reset link to the given user.
     *
     * @return \Response
     */
    public function postEmail()
    {
        $this->registrar->sendResetPasswordLinkViaEmail();

        if ($this->request->ajax() || $this->request->wantsJson()) {
            return ['message' => trans(PasswordBroker::RESET_LINK_SENT)];
        }

        return redirect()->back()->with('message', trans(PasswordBroker::RESET_LINK_SENT));
    }

    /**
     * Display the password reset view for the given token.
     *
     * @param  string $token
     *
     * @return \Response
     *
     * @throws NotFoundHttpException
     */
    public function getReset($token = null)
    {
        if (is_null($token)) {
            if ($this->request->ajax() || $this->request->wantsJson()) {
                throw new TokenNotValidException();
            }

            return view('password/reset')->withErrors(['token' => trans(PasswordBroker::INVALID_TOKEN)]);
        }

        if ($this->request->ajax() || $this->request->wantsJson()) {
            return ['token' => $token];
        }

        return view('password/reset')->with('token', $token);
    }

    /**
     * Reset the given user's password.
     *
     * @return \Response
     */
    public function postReset()
    {
        $this->registrar->resetPassword();

        if ($this->request->ajax() || $this->request->wantsJson()) {
            return ['message' => 'Password successfully reset'];
        }

        return redirect($this->redirectPath())->with('message', trans(PasswordBroker::PASSWORD_RESET));
    }

    /**
     * Get the post-register/-login redirect path.
     *
     * @return string
     */
    private function redirectPath()
    {
        if (isset($this->redirectPath)) {
            return $this->redirectPath;
        }

        return isset($this->redirectTo) ? $this->redirectTo : '/login';
    }
}
