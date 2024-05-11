<?php

// {$form.controller_title}验证器
namespace {$validate.namespace}\{$form.group};

use think\Validate;

class {$validate.class_name} extends Validate
{
    // 验证规则
    protected $rule = [
        'useless_field' => ['require'],//无用字段
    {foreach $tables[0].datas as $k=>$item}
        {if '{$item.check}'}'{$item.field}' => '{foreach $item.check as $j=>$checkItem}{$checkItem.value}{if {$j}<{$count(item.check)}-1}|{/if}{/foreach}',{/if}
        {if !'{$item.check}' && '{$item.not_null}'}'{$item.field}' => 'require',{/if}
    {/foreach}
    ];

    // 错误信息
    protected $message = [
    {foreach $tables[0].datas as $k=>$item}
    {if '{$item.check}'}
        {foreach $item.check as $j=>$checkItem}'{$item.field}.{$checkItem.value}' => '{$checkItem.message}',{/foreach}
    {/if}
    {/foreach}
    ];

    // 验证场景
    // 详情验证场景定义
    public function sceneShow()
    {
        return $this->only(['id']);
    }

    // 删除验证场景定义
    public function sceneDelete()
    {
        return $this->only(['id']);
    }


    // 新增验证场景定义
    public function sceneCreate()
    {
        return $this->remove(['id' => true, 'useless_field' => true]);
    }

    // 更新验证场景定义
    public function sceneUpdate()
    {
        return $this->remove('useless_field',true);
    }
}
