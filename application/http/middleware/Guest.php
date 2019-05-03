<?php

namespace app\http\middleware;
use think\facade\Session;

class Guest
{
    public function handle($request, \Closure $next)
    {
        if (Session::has('user')){
            return redirect('/')->with('info','您已登录，无需执行此操作');
        }

        return $next($request);
    }
}
