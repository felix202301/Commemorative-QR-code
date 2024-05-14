<?php
declare (strict_types = 1);

namespace app\api\controller;

// 必须的
use hg\apidoc\annotation as Apidoc;

#[Apidoc\Title("基础示例")]
class Index
{
    #[
        Apidoc\Title("基础的演示"),
        Apidoc\Tag("基础,示例"),
        Apidoc\Method("GET"),
        Apidoc\Url("/api/index/index"),
        Apidoc\Query(name:"name",type: "string",require: true,desc: "姓名",mock:"@name"),
        Apidoc\Query(name:"phone",type: "string",require: true,desc: "手机号",mock:"@phone"),
        Apidoc\Returned("id",type: "int",desc: "Id"),
    ]
    public function index()
    {
        echo phpinfo();
        return '您好！这是一个[api]示例应用';
    }
}
