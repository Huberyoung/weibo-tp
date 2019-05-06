<?php

namespace app\index\controller;

use think\Controller;
use think\facade\Session;
use think\Request;
use app\common\model\PasswordResets as PasswordModel;
use app\common\model\Users as UserModel;
use think\response\Redirect;

class ForgotPassword extends Controller
{
    protected $batchValidate = true;
    protected $middleware = [
        'Guest' => ['only' 		=> ['create','showLinkRequestForm', 'showResetForm'] ],
    ];

    public function showLinkRequestFormOp()
    {
        $data['email'] = '';
        $this->assign('old',$data);
        return $this->fetch('password/email');
    }

    public function sendResetLinkEmailOp(Request $request)
    {
        if ($request->isPost()) {
            $data = $request->param();
            $errors = $this->validate($data,'app\index\validate\Email');
            if($errors === true) {
                $token = md5(md5($data['email']).md5(time()));
                $password = PasswordModel::create([
                    'email' => $data['email'],
                    'token' => $token,
                ]);
                $this->sendEmailConfirmationTo($password);
                Session::flash('status','重置邮件已发送!');
                return redirect('/password/request');
            } else {
                $this->assign('errors',$errors);
            }
            $this->assign('old',$data);
            return view('password/email');
        }
    }

    public function showResetFormOp($token)
    {
        $password = PasswordModel::where('token', $token)->find();
        $password->token = 1;
        $password->save();
        $data = [
            'email'                 => $password['email'],
            'password'              => '',
            'password_confirmation' => '',
        ];
        $this->assign('old',$data);
        return view('password/reset');
    }

    public function resetOp(Request $request)
    {
        if ($request->isPost()) {
            $data = $request->param();
            $errors = $this->validate($data,'app\index\validate\Password');
            if($errors === true) {
                $user = UserModel::where('email', $data['email'])->find();
                $user->password = md5($data['password']);
                $user->save();
                Session::set('user',$user);
                return redirect('users/read',[$user->id])->with('success','密码更新成功！欢迎您再次登录');
            } else {
                $this->assign('errors',$errors);
            }
            $this->assign('old',$data);
            return view('password/reset');
        }
    }

    public function sendEmailConfirmationTo($password)
    {
        $to      = $password->email;
        $title   = '感谢您使用 Weibo App 网站！请确认你的邮箱.';
        $url = 'http://www.weibo.test'.url('password/reset/',[$password->token]);
        $content = "<h1>感谢您使用 Weibo App 网站！</h1><p>请点击下面的链接进行密码重置：<a href=".$url.">".$url."</a></p><p>如果这不是您本人的操作，请忽略此邮件。</p>";
        $result = sendMail($to,$title,$content);
        return $result;
    }
}
