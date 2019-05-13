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
}
