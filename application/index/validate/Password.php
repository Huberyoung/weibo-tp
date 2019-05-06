<?php

namespace app\index\validate;

use think\Validate;

class Password extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'password'              => 'require|min:6',
        'password_confirmation' => 'require|confirm:password'
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'password.min'    => '密码不能少于6位',
        'password.require'=> '密码不能为空',
        'password_confirmation.require'=> '确认密码不能为空',
        'password_confirmation.confirm' => '两次密码输入不一致'
    ];
}
