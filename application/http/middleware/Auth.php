<?php

namespace app\http\middleware;
use think\facade\Session;

class Auth
{
    public function handle($request, \Closure $next)
    {
        if (!Session::has('user')){
            return redirect('/login')->with('warning','您未登录，请登录后操作')->remember();;
        }

        return $next($request);
    }
}
