<?php

namespace app\index\controller;

use app\common\model\Users as UserModel;
use think\Controller;
use think\facade\Session;
use think\Request;

class statuses extends Controller
{
    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function saveOp(Request $request)
    {
        $rule = [
            'content'  => 'require|max:140',
        ];

        $msg = [
            'content.require' => '内容不能为空',
            'content.max'     => '内容最多不能超过140个字符',
        ];
        $validate   = Validate::make($rule,$msg);

        if($request->isPut()) {
            $data   = $request->param();
            $errors = $validate->check($data);
            if((($errors !== true) && (is_array($errors)))){
//                $this->assign('errors',$errors);
//                $this->assign('old',$user);
//                return $this->fetch('edit',['id' => $id]);
            } else {
                $user   = Session::get('user');
                $user->statuses()->content = $data['content'];
                $user->statuses()->save();
                Session::flash('success','发布成功！');
                return redirect()->back();
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
