<?php

namespace app\common\model;

use think\Model;

class Users extends Model
{
    protected $autoWriteTimestamp = 'datetime';
    protected $createTime = 'create_at';
    protected $updateTime = 'update_at';

//    public function gravatar($user, $size = '100')
//    {
//        $hash = md5(strtolower(trim($user->email)));
//        return "http://www.gravatar.com/avatar/$hash?s=$size";
//    }
}
