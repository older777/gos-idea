<?php

namespace Older777\GosIdea\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

final class GosIdeaServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        RateLimiter::for('huntingCore', function (Request $request) {
            return Limit::perMinute(4)->response(function (Request $request, array $headers) {
                return response()->json([
                    'success' => 'false',
                    'message' => 'Слишком много запросов в минуту',
                ], Response::HTTP_TOO_MANY_REQUESTS, [], JSON_UNESCAPED_UNICODE);
            });
        });

        $this->loadRoutesFrom(__DIR__.'/../routes/api.php');

        $this->publishesMigrations([__DIR__.'/../database/migrations' => database_path('migrations')]);
    }
}
