<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\AnalyticRequest;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class TrackAnalytics
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);

        $response = $next($request);

        $duration = (microtime(true) - $startTime) * 1000;

        $requestData = [
            'route' => $request->path(),
            'method' => $request->method(),
            'duration_ms' => round($duration, 2),
            'status_code' => $response->getStatusCode(),
            'user_agent' => $request->userAgent(),
            'user_id' => auth()->check() ? auth()->id() : null,
            'visitor_id' => $this->getVisitorId($request),
            'session_id' => session()->getId(),
            'ip_address' => $request->ip(),
            'date' => now()->toDateString(),
        ];

        dispatch(function () use ($requestData) {
            AnalyticRequest::create($requestData);
        })->afterResponse();

        return $response;
    }

    private function getVisitorId(Request $request): ?string
    {
        $cookieName = config('app.visitor_cookie_name');

        if ($request->hasCookie($cookieName)) {
            return $request->cookie($cookieName);
        }

        $visitorId = Str::uuid()->toString();

        cookie()->queue(cookie($cookieName, $visitorId, 60 * 24 * 365 * 2));

        return $visitorId;
    }
}
