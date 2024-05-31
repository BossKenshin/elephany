<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLearner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->utype === 'learner') {
            return $next($request);
        }

        // Redirect or return an error response if the user is not a teacher
        return redirect('/home'); // or return response()->json(['message' => 'Unauthorized'], 403);
     }
}
