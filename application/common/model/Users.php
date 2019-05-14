<?php

namespace app\common\model;

use think\Model;

class Users extends Model
{
    protected $autoWriteTimestamp = 'datetime';
    protected $createTime = 'create_at';
    protected $updateTime = 'update_at';

    public function statuses()
    {
        return $this->hasMany('Statuses','user_id');
    }

    public function feed()
    {
        return $this->statuses()
            ->order('created_at','desc');
    }

    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->email)));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }
}
