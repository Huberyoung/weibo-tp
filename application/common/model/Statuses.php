<?php

namespace app\common\model;

use think\Model;

class Statuses extends Model
{
    protected $autoWriteTimestamp = 'datetime';
    protected $createTime = 'create_at';
    protected $updateTime = 'update_at';

    public function user()
    {
        return $this->belongsTo('Users');
    }
}
