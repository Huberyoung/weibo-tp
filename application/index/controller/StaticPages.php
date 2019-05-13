<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use think\facade\Session;

class StaticPages extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function homeOp()
    {
        if (Session::has('user')) {
            $user       = Session::get('user');
            $feed_items = $user->feed()->paginate(10);
            $this->assign('feed_items',$feed_items);
            $this->assign('user',$user);
        }
        $old = ['content'=>''];
        $this->assign('old',$old);
        return $this->fetch();
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function aboutOp()
    {
        return $this->fetch();
    }

    public function helpOp()
    {
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
        //
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
