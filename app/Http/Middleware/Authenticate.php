<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
        // return $request->expectsJson() ? null : response()->json([
        //     'status' => 'Unauthorized',
        // ], 401);
    }

    /// Method untuk mengoverride unathorized token dari middleware
    // protected function unauthenticated($request, array $guards)
    // {
    //     if ($request->expectsJson()) {
    //         return response()->json(['error' => 'Unauthenticated.'], 401);
    //     }
    //     return redirect()->guest(route('login'));
    //     // abort(response()->json(
    //     //     [
    //     //         'api_status' => '401',
    //     //         'message' => 'UnAuthenticated',
    //     //     ],
    //     //     401
    //     // ));
    // }
}
