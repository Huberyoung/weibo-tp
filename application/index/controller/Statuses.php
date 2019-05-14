<?php

namespace app\index\controller;

use app\common\model\Users as UserModel;
use app\common\model\Statuses as StatusModel;
use think\Controller;
use think\facade\Session;
use think\Request;

class Statuses extends Controller
{
    protected $batchValidate = true;
    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function saveOp(Request $request)
    {
        $user = Session::get('user');
        if($request->isPost()) {
            $data   = $request->param();
            $errors = $this->validate($data,'app\index\validate\Content');
            if((($errors !== true) && (is_array($errors)))){
                $this->assign('errors',$errors);
                $this->assign('old',$data);
                $this->assign('user',$user);
                return $this->fetch('/static_pages/home');
            } else {
                $user->statuses()->save([
                    'content'  => $data['content']
                ]);
                Session::flash('success','发布成功！');
                return redirect('/');
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
        $status =  StatusModel::get($id);
        if ($this->checkAuth($status->user_id)){
            $status ->delete();
            Session::flash('success','微博已被成功删除！');
        } else {
            Session::flash('warning','对不起，您没有操作权限！');
        }
        return Redirect($_SERVER["HTTP_REFERER"]);
    }

    public function checkAuth($current_id)
    {
        return ($current_id === Session::get('user')->id) || (Session::get('user')->is_admin == 1);
    }
}
