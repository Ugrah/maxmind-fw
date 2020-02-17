<?php
/*
|--------------------------------------------------------------------------
| Routes
|--------------------------------------------------------------------------
|
| This is the application global routes.
|
*/
$app->group('', function () {
    // Home - Dashboard
    $this->get('/', App\Controllers\HomeController::class . ':index')->setName('home');
    $this->post('/', App\Controllers\HomeController::class . ':newAction');

})/*->add(new App\Middlewares\Authenticated(
    $container->get(Cartalyst\Sentinel\Sentinel::class),
    $container->get('router')
))*/;

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
|
| This is the core routes of the application authentication.
|
*/
$app->group('/auth', function () {
    $this->get('/login', App\Controllers\Auth\LoginController::class . ':index')->setName('auth.login');
    $this->post('/login', App\Controllers\Auth\LoginController::class . ':login');
    $this->get('/register', App\Controllers\Auth\RegisterController::class . ':index')->setName('auth.register');
    $this->post('/register', App\Controllers\Auth\RegisterController::class . ':register');
})->add(new App\Middlewares\Guest($container->get(Cartalyst\Sentinel\Sentinel::class)));
