<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Device;

class DeviceApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
    $deviceApiKey = $request->header('X-API-KEY');

    if (empty($deviceApiKey)) {
        return response()->json(['error' => 'Missing deviceApiKey header'], 401);
    }

    $device = Device::where('device_api_key', $deviceApiKey)->first();

    if (!$device) {
        return response()->json(['error' => 'Invalid deviceApiKey'], 401);
    }

    // Place the device in a request for further use
    $request->device = $device;


        return $next($request);
    }
}
