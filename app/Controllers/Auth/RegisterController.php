<?php


namespace App\Controllers\Auth;

use Cartalyst\Sentinel\Sentinel as Auth;
// use App\Auth\Hashing\HasherInterface;
use App\Controllers\Controller;
use App\Email\Mailer;
use App\Email\Templates\Welcome;
use App\Models\User;
use App\Session\Flash;
use App\Views\View;
use Slim\Http\Request;
use Slim\Http\Response;

class RegisterController extends Controller
{
    protected $view;

    // protected $hasher;

    protected $auth;

    protected $flash;

    private $mailer;

    public function __construct(View $view, Auth $auth, Flash $flash, Mailer $mailer)
    {
        $this->view = $view;
        // $this->hasher = $hasher;
        $this->auth = $auth;
        $this->flash = $flash;
        $this->mailer = $mailer;
    }

    public function index(Request $request, Response $response)
    {
        return $this->view->render($response, 'auth/register.twig');
    }

    public function register(Request $request, Response $response)
    {
        $data = $this->validateRegistration($request);

        $user = $this->auth->registerAndActivate([
            'first_name' => $data['username'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);
        
        // Send welcome email to newly registered user
        // $this->mailer->to($user->email, $user->username)->send(new Welcome($user));

        if ($this->auth->Authenticate([
            'email' => $data['email'],
            'password' => $data['password']
        ])) {
            $_SESSION['email'] = $data['email'];
            $this->flash->now('success', 'You were successfully registered!');
            return $response->withRedirect('/profile');
        }

        return $response->withRedirect('/');
    }

    protected function validateRegistration(Request $request)
    {
        return $this->validate($request, [
           'email' => ['required', 'email', ['exists', User::class]],
           'username' => ['required'],
           'password' => ['required'],
           'password_confirmation' => ['required', ['equals', 'password']],
        ]);
    }
}
