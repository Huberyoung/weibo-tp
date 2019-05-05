<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use app\common\model\Users;
use think\facade\Session;
use think\facade\Cookie;

class Sessions extends Controller
{
    protected $batchValidate = true;
    protected $middleware = [
        'Guest' => ['only' 		=> ['create'] ],
    ];
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function indexOp()
    {
        //
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function createOp()
    {
        if (Session::has('old')) {
            $old = Session::get('old');
        } else {
            $old = [
                'email'    => '',
                'password' => '',
            ];
        }
        $this->assign('old',$old);
        return $this->fetch();
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function saveOp(Request $request)
    {
        if ($request->isPost()) {
            $data   = $request->param();
            $errors = $this->validate($data,'app\index\validate\Sessions');
            if (($errors !== true) && (is_array($errors))) {
                $this->assign('errors', $errors);
                $this->assign('old', $data);
                return view('create');
            } else {
                $user = Users::getByEmail($data['email']);
                if($user['password'] != md5($data['password']))
                {
                    Session::flash('danger','很抱歉，您的邮箱和密码不匹配！');
                    Session::flash('old',$data);
                    return redirect('create');
                } else {
                    if (!empty($data['remember'])){
                        $this->rememberMe($user);
                    }
                    Session::set('user',$user);
                    Session::flash('success','欢迎回来！');
                    return redirect('users/read',[$user->id]);
                }
            }
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function deleteOp()
    {
        Session::delete('user');
        Session::flash('success','您已成功退出！');
        return redirect('create');
    }

    public function rememberMe($user)
    {
        $rememberToken = md5($user['name']).md5($user['email']);
        $user = Users::get($user->id);
        $user->rememberToken = $rememberToken;
        $user->save();
        Cookie::set('auth',$user->id.':'.$rememberToken,30*24*60*60);
    }
}
