<?php

namespace app\Index\controller;

use app\common\model\Users as UserModel;
use think\Controller;
use think\facade\Session;
use think\facade\Cookie;
use think\Request;
use think\response\Redirect;


class Users extends Controller
{
    protected $batchValidate = true;
    protected $middleware = [
        'Auth' 	=> ['except' 	=> ['create', 'save' ,'read', 'index', 'confirm'] ],
        'Guest' => ['only' 		=> ['create'] ],
    ];
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function indexOp()
    {
        $users = UserModel::where('id','>',0)->paginate(10);
        $this->assign('users',$users);
        return $this->fetch();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function createOp()
    {
        $old = [
            'name'                  => '',
            'email'                 => '',
            'password'              => '',
            'password_confirmation' => ''
        ];
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
        if($request->isPost()) {
            $data = $request->param();
            $errors = $this->validate($data,'app\index\validate\Users');
            if ($errors === true) {
                $activation_token = md5($request->param('email').$request->param('name'));
                $user = new UserModel([
                    'name'             => $request->param('name'),
                    'email'            => $request->param('email'),
                    'password'         => md5($request->param('password')),
                    'activation_token' => $activation_token,
                ]);
                $user->save();
                $this->sendEmailConfirmationTo($user);
                Session::flash('success','验证邮件已发送到你的注册邮箱上，请注意查收。');
                return redirect('/');
            } else {
                $this->assign('errors',$errors);
                $this->assign('old',$data);
                return view('create');
            }
        }
    }
    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function readOp($id)
    {
        $user = UserModel::get($id);

        $statuses = $user->statuses()
            ->order('created_at','desc')
            ->paginate(10);

        $this->assign('statuses', $statuses);
        $this->assign('user', $user);

        return $this->fetch();
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function editOp($id)
    {
        if ($this->check($id)){
            $user = UserModel::get($id);
            $this->assign('old',$user);
            return $this->fetch();
        } else {
            $this->error('很抱歉，您没有操作权限！');
        }
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function updateOp(Request $request, $id)
    {
        if($request->isPut()) {
            if ($this->check($id)) {
                $data = $request->param();
                $errors = $this->validate($data,'app\index\validate\UsersEdit');
                $user = UserModel::get($id);
                if((($errors !== true) && (is_array($errors)))){
                    $this->assign('errors',$errors);
                    $this->assign('old',$user);
                    return $this->fetch('edit',['id' => $id]);
                } else {
                    if (!empty($data['password'])) {
                        $user->password = md5($data['password']);
                    }
                    $user->name = $data['name'];
                    $user->save();
                    Session::set('user',$user);
                    return redirect('users/read',[$user->id])->with('success','个人资料更新成功！');
                }
            } else {
                $this->error('很抱歉，您没有操作权限！');
            }
        }
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function deleteOp($id)
    {
       if ($this->checkIsAdmin($id)){
           UserModel::destroy($id);
           Session::flash('success','成功删除用户！');
           return Redirect($_SERVER["HTTP_REFERER"]);
       }
    }

    public function sendEmailConfirmationTo($user)
    {
        $to      = $user->email;
        $title   = '感谢注册 Weibo 应用！请确认你的邮箱.';
        $url = 'http://'.$_SERVER['SERVER_NAME'].url('signup/confirm/',[$user->activation_token]);
        $content = "<h1>感谢您在 Weibo App 网站进行注册！</h1><p>请点击下面的链接完成注册：<a href=".$url.">".$url."</a></p><p>如果这不是您本人的操作，请忽略此邮件。</p>";
        $result = sendMail($to,$title,$content);
        return $result;
    }

    public function confirmOp($token)
    {
        if (!empty($token)) {
            $user = UserModel::where('activation_token', $token)->find();
            $user->activated = true;
            $user->activation_token = null;
            $user->save();
            Session::set('user',$user);
            return redirect('users/read',[$user->id])->with('success','恭喜你，激活成功！');
        }
        return redirect('/')->with('warning','您的token无效');
    }

    public function check($current_id)
    {
        return ($current_id == Session::get('user')->id);
    }

    public function checkIsAdmin($current_id)
    {
        return (($current_id != Session::get('user')->id) && (Session::get('user')->is_admin == 1));
    }
}
