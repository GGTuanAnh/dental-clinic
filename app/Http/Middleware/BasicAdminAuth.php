<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BasicAdminAuth
{
    // DEPRECATED: Replaced by session-based auth (see AdminAuthController + 'auth' middleware)
    public function handle(Request $request, Closure $next): Response
    {
        $user = env('ADMIN_USER');
        $pass = env('ADMIN_PASS');
        if(!$user || !$pass){
            // If not configured, deny by default
            return response('Admin authentication not configured', 403);
        }

        $providedUser = null; $providedPass = null;
        if(isset($_SERVER['PHP_AUTH_USER'])){
            $providedUser = $_SERVER['PHP_AUTH_USER'] ?? null;
            $providedPass = $_SERVER['PHP_AUTH_PW'] ?? null;
        } else {
            $auth = $request->header('Authorization');
            if($auth && str_starts_with($auth, 'Basic ')){
                $decoded = base64_decode(substr($auth, 6));
                if($decoded && str_contains($decoded, ':')){
                    [$providedUser, $providedPass] = explode(':', $decoded, 2);
                }
            }
        }

        if(!($providedUser !== null && $providedPass !== null
            && hash_equals($user, (string)$providedUser)
            && hash_equals($pass, (string)$providedPass))){
            return response('Unauthorized', 401)->header('WWW-Authenticate', 'Basic realm="Admin Area"');
        }

        return $next($request);
    }
}
