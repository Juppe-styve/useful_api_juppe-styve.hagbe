<?php

namespace App\Http\Middleware;

use App\Models\UserModules;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckModuleActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $module = UserModules::where(["user_id" => auth()->id(), "module_id" => $request->module_id])->first();
        if ($module && $module->active) {
            return $next($request);
        }
        return response([
            "error" => "Module inactive. Please activate this module to use it."
        ], 403);
    }
}