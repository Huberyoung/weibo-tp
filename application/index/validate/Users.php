<?php

namespace app\index\validate;

use think\Validate;

class Users extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */

	protected $rule = [
	    'name'                  => 'require|max:50|min:3',
        'email'                 => 'require|email|max:255|unique:users',
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
        'name.require'    => '名称不能为空',
        'name.max'        => '名称不能多于50个字符',
        'name.min'        => '名称不能少于3个字符',
        'email.require'   => '邮箱不能为空',
        'email.unique'    => '邮箱已注册',
        'email'           => '邮箱格式错误',
        'password.min'    => '密码不能少于6位',
        'password_confirmation.confirm' => '两次密码输入不一致'
    ];
}
