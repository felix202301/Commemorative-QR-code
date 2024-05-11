<?php


namespace app\common;

use hg\apidoc\annotation\Param;
use hg\apidoc\annotation\Returned;
use hg\apidoc\annotation\Header;

class ApiDocDefinitions
{
    /**
     * 获取分页数据列表的参数
     * @Param("page", type="int",require=true,default=1, desc="当前页")
     * @Param("pageSize", type="int",require=true,default=20, desc="分页大小")
     * @Param("sortField", type="string",require=false,default="id", desc="排序字段")
     * @Param("sortBy", type="string",require=false,default="desc", desc="排序方式")
     * @Returned("total", type="int", desc="总条数")
     */
    public function indexParam(){}

    /**
     * 返回字典数据
     * @Returned("id",type="int",desc="唯一id")
     * @Returned("name",type="string",desc="字典名")
     * @Returned("value",type="string",desc="字典值")
     */
    public function dictionary(){}

    /**
     * @Header("token",type="string",require=true,desc="身份票据")
     * @Header("shopid",type="string",require=true,desc="店铺id")
     */
    public function auth(){}
}
