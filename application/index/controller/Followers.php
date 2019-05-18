<?php

namespace app\index\controller;

use app\common\model\Users;
use think\Controller;
use think\Request;
use think\facade\Session;

class Followers extends Controller
{
    protected $middleware = [
        'Auth'
    ];
    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function saveOp($id)
    {
        $currentUser = Session('user');
        $user = Users::get($id);
        if(!$currentUser->isFollowing($user->id)) {
            $currentUser->follow($user->id);
        }
        return redirect('users/read',['id'=>$user->id]);
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function deleteOp($id)
    {
        $currentUser = Session('user');
        $user = Users::get($id);
        if($currentUser->isFollowing($user->id)) {
            $currentUser->unFollow($user->id);
        }
        return redirect('users/read',['id'=>$user->id]);
    }
}
