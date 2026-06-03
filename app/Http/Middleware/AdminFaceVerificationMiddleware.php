<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminFaceVerificationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only apply if user is authenticated and is an admin
        if ($request->user() && $request->user()->role === 'admin') {
            // Check if current route is NOT the face verification page or the post request handler
            if (!$request->routeIs('admin.verify-face') && !$request->routeIs('admin.verify-face.post')) {
                if (!session()->get('admin_face_verified')) {
                    return redirect()->route('admin.verify-face');
                }
            }
        }

        return $next($request);
    }
}
