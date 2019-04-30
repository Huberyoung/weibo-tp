<?php

namespace app\index\validate;

use think\Validate;

class Sessions extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
        'email'                 => 'require|email|max:255',
        'password'              => 'require|min:6',
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'email.require'   => '邮箱不能为空',
        'email.max'       => '邮箱不能超过255个字符',
        'email'           => '邮箱格式错误',
        'password.min'    => '密码不能少于6位',
    ];
}
