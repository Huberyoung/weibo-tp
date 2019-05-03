<?php

namespace app\http\middleware;
use think\facade\Session;

class Auth
{
    public function handle($request, \Closure $next)
    {
        if (!Session::has('user')){
            Session::flash('warning','您未登录，请登录后操作');
            return redirect('/login');
        }

        return $next($request);
    }
}
