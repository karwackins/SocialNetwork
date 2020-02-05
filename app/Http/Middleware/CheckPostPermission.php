<?php

namespace App\Http\Middleware;

use App\Post;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPostPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $post_exist = Post::where([
            'id' => $request->post,
            'user_id' => Auth::id(),
        ])->exists();
        if((!Auth::check() || ! $post_exist) && ! is_admin())
        {
            abort(403, 'Brak dostępu');
        }
        return $next($request);
    }
}
