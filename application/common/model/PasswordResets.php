<?php

namespace app\common\model;

use think\Model;

class PasswordResets extends Model
{
    protected $autoWriteTimestamp = 'datetime';
    protected $createTime = 'created_at';
}
