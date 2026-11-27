<?php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Symfony\Component\HttpKernel\Exception\HttpException;
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(web: __DIR__.'/../routes/web.php', commands: __DIR__.'/../routes/console.php', health: '/up')
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias(['role' => \App\Http\Middleware\EnsureRole::class]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (HttpException $exception, Request $request) {
            if (
                $exception->getStatusCode() !== 419
                || !($exception->getPrevious() instanceof TokenMismatchException)
                || !$request->routeIs('register.submit')
            ) return null;

            $role = $request->input('role');
            $message = 'Your registration session expired. Please review the form and submit it again.';
            if (in_array($role, ['student', 'staff', 'admin'], true)) {
                return redirect()->route('register', ['role' => $role])
                    ->withErrors(['session' => $message])
                    ->withInput($request->except(['_token', 'password', 'password_confirmation']));
            }

            return redirect()->route('roles', ['mode' => 'signup'])
                ->withErrors(['session' => $message]);
        });
    })
    ->create();
