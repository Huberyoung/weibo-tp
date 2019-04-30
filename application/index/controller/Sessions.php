<?php

namespace app\index\controller;

use think\Controller;
use think\Request;

class Sessions extends Controller
{
    protected $batchValidate = true;
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
        $old = [
            'email'    => '',
            'password' => '',
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
        if ($request->isPost()) {
           $data   = $request->param();
           $errors = $this->validate($data,'app\index\validate\Sessions');
            if (($errors !== true) && (is_array($errors))) {
                $this->assign('errors', $errors);
                $this->assign('old', $data);
                return view('create');
            } else {
//                $user = new UserModel([
//                    'name'     => $request->param('name'),
//                    'email'    => $request->param('email'),
//                    'password' => md5($request->param('password')),
//                ]);
//                $user->save();
//                return redirect('users/read',[$user->id])->with('success','欢迎，您将在这里开启一段新的旅程~');
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
        //
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
}
