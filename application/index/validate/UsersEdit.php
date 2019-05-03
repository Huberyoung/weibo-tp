<?php

namespace app\index\validate;

use think\Validate;

class UsersEdit extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'name'                  => 'require|max:50|min:3|token',
        'password'              => 'min:6',
        'password_confirmation' => 'min:6|confirm:password'
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */
    protected $message = [
        'name.require'    => '名称不能为空',
        'name.max'        => '名称不能多于50个字符',
        'name.min'        => '名称不能少于3个字符',
        'password.min'    => '密码不能少于6位',
        'password_confirmation.min'    => '确认密码不能少于6位',
        'password_confirmation.confirm' => '两次密码输入不一致'
    ];
}
