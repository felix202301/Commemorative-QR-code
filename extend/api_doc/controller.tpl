<?php

// {$form.controller_title}控制器
namespace {$controller.namespace}\{$form.group};

use app\Request;
use app\admin\controller\BaseController;
use {$validate.namespace}\{$form.group}\{$validate.class_name} as {$validate.class_name}Validate;
use hg\apidoc\annotation as apiDoc;

/**
 * @apiDoc\Title("{$form.controller_title}")
 * @apiDoc\Group("{$form.group}")
 */
class {$controller.class_name} extends BaseController
{
    /**
     * @apiDoc\Title("{$form.controller_title}列表")
     * @apiDoc\Method("GET")
     * @Apidoc\Author("")
     * @apiDoc\Url("admin.php/{$form.group}/{$controller.class_name}")
     * @apiDoc\Param(ref="indexParam")
     * @apiDoc\Returned("list", type="array", desc="列表",
     *     @apiDoc\Returned(ref="",withoutField=""),
     * )
     * @apiDoc\Returned(ref="indexParam")
     */
    public function index()
    {
        $page = $this->request->param('page/d', 1);
        $pageSize = $this->request->param('pageSize/d', 20);
        $sortField = $this->request->param('sortField', 'id');
        $sortBy = $this->request->param('sortBy', 'desc');
        $where = [];

        $list = {$controller.class_name}Model::where($where);
        $total = $list->count();
        $list = $list->field(true)->order($sortField, $sortBy)->page($page, $pageSize)->select();
        return success([
            'list' => $list,
            'total' => $total
        ], '获取信息成功');
    }

    /**
    * @apiDoc\Title("{$form.controller_title}详情")
    * @apiDoc\Desc("请将连接后面的:id替换成要查询数据的id")
    * @apiDoc\Method("GET")
    * @Apidoc\Author("")
    * @apiDoc\Url("/admin.php/{$form.group}/{$controller.class_name}/:id")
    * @apiDoc\Param("id", type="int",require=true,default=0, desc="ID")
    * @apiDoc\Returned("detail", type="object", desc="详情信息",
    *     @apiDoc\Returned(ref="",withoutField=""),
    * )
    * @param $id
    * @return \think\response\Json
    */
    public function read(int $id = 0)
    {
        $detail = (object)[];
        if ($id > 0) {
            $detail = {$controller.class_name}Model::find($id);
        }
        return success([
            'detail' => $detail,
        ], '获取信息成功');
    }

    /**
    * @apiDoc\Title("{$form.controller_title}添加")
    * @apiDoc\Desc("")
    * @apiDoc\Method("POST")
    * @Apidoc\Author("")
    * @apiDoc\Url("/admin.php/{$form.group}/{$controller.class_name}")
    * @apiDoc\Param(ref="",withoutField="")
    * @param Request $request
    * @return \think\response\Json
    */
    public function save(Request $request)
    {
        $param = $this->request->param();
        //验证器
        validate({$validate.class_name}Validate::class)->scene('create')->check($param);
        $res = $this->creatOrUpdate($param, $request);
        return success($res, true);
    }

    /**
    * @apiDoc\Title("{$form.controller_title}编辑")
    * @apiDoc\Desc("")
    * @apiDoc\Method("PUT")
    * @Apidoc\Author("")
    * @apiDoc\Url("/admin.php/{$form.group}/{$controller.class_name}/:id ")
    * @apiDoc\Param(ref="",withoutField="")
    * @param Request $request
    * @param $id
    * @return \think\response\Json
    */
    public function update(Request $request, $id)
    {
        $param = $request->param();
        //验证器
        validate({$validate.class_name}Validate::class)->scene('update')->check($param);
        $res = $this->creatOrUpdate($param, $request, $id);
        return success($res, true);
    }
    /**
    * @apiDoc\Title("{$form.controller_title}删除")
    * @apiDoc\Desc("")
    * @apiDoc\Method("DELETE")
    * @Apidoc\Author("")
    * @apiDoc\Url("/admin.php/{$form.group}/{$controller.class_name}/:id ")
    * @apiDoc\Param("id", type="int",require=true,desc="ID")
    * @param $id
    * @return \think\response\Json
    */
    public function delete($id)
    {
        if (!$id) return json(['code' => 400, 'msg' => 'id为空']);
        Db::transaction(function () use ($id) {
            $res = {$controller.class_name}Model::destroy($id);
            if (!$res) {
                return error();
            }
        });
        return success();
    }

    //新增或修改
    public function creatOrUpdate($data, $request, $id = 0)
    {
        if ($id > 0) {
            $detail = {$controller.class_name}Model::find($id);
            if (!$detail) return ['code' => 5000, 'message' => '资源不存在'];
            unset($data['create_time']);
            $detail->save($data);
        } else {
            $detail = {$controller.class_name}Model::create($data);
            //$id = $detail['id'];
        }
        return ['code' => 2000, 'message' => '成功'];
    }
}
