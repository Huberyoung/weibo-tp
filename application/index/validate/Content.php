<?php

namespace app\index\validate;

use think\Validate;

class Content extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = ['content'  => 'require|max:140',];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'content.require' => '内容不能为空',
        'content.max'     => '内容最多不能超过140个字符',
    ];
}
