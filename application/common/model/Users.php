<?php

namespace app\common\model;

use think\Model;

class Users extends Model
{
    protected $autoWriteTimestamp = 'datetime';
    protected $createTime = 'create_at';
    protected $updateTime = 'update_at';
}
