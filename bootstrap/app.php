<?php
use Illuminate\Foundation\Application; use Illuminate\Foundation\Configuration\Middleware; use App\Http\Middleware\{EnsureInstalled,AdminOnly};
return Application::configure(basePath: dirname(__DIR__))->withRouting(web: __DIR__.'/../routes/web.php',commands: __DIR__.'/../routes/console.php',health:'/up')->withMiddleware(function(Middleware $middleware){$middleware->web(append:[EnsureInstalled::class]);$middleware->alias(['admin'=>AdminOnly::class]);})->withExceptions(function($exceptions){})->create();
