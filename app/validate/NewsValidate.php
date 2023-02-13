<?php

namespace app\validate;

use nickbai\tp6curd\extend\ExtendValidate;

class NewsValidate extends ExtendValidate
{
    protected $rule = [
//    'id' => 'require',
    'title' => 'require',
    'context' => 'require',
//    'created_at' => 'require',
//    'updated_at' => 'require',
];

    protected $attributes = [
    'id' => '主键',
    'title' => '标题',
    'context' => '内容',
    'created_at' => '添加时间',
    'updated_at' => '修改时间',
];
    protected $message = [
        'title.require' => '标题不能为空',
        'context.require' => '内容不能为空',

    ];
}