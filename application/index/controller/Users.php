<?php

namespace app\Index\controller;

use app\common\model\Users as UserModel;
use think\Controller;
use think\Request;

class Users extends Controller
{
    protected $batchValidate = true;
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function indexOp()
    {
        phpinfo();
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
        $data = $request->param();
        if($request->isPost()) {
            $data = $request->param();
            $errors = $this->validate($data,'app\index\validate\Users');
            if(($errors !== true) && (is_array($errors))){
                $this->assign('errors',$errors);
                $this->assign('old',$data);
                return view('create');
            } else {
                $user = new UserModel([
                    'name'     => $request->param('name'),
                    'email'    => $request->param('email'),
                    'password' => md5($request->param('password')),
                ]);
                $user->save();
                return redirect('users/read',[$user->id])->with('success','欢迎，您将在这里开启一段新的旅程~');
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

        $user->gravatar = $this->gravatar($user);

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
        //
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
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function deleteOp($id)
    {
        //
    }

    public function gravatar($user, $size = '100')
    {
        $hash = md5(strtolower(trim($user->email)));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }
}
