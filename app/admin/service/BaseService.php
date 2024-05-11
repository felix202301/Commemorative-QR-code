<?php

namespace app\admin\service;

class BaseService
{

    // 模型
    protected $model;
    //显示资源列表
    public function index()
    {
        $page = $this->request->param('page/d', 1);
        $pageSize = $this->request->param('pageSize/d', 20);
        $sortField = $this->request->param('sortField', 'id');
        $sortBy = $this->request->param('sortBy', 'desc');
        $timeField = $this->request->param('timeField', 'login_time');
        $dateValue = $this->request->param('dateValue', '');
        $name = $this->request->param('name', '');
        $status = $this->request->param('status/d', 0);
        $where = [];
        if ($name) $where[] = ['name', 'like', "%{$name}%"];
        if ($status) $where[] = ['status', '=', $status];
        $adminId = $this->request->adminId;
        if ($adminId > 1) $where[] = ['admin_id', '=', $adminId];
        $list = $this->model::where($where);
        if ($dateValue) $list->whereTime($timeField, 'between', $dateValue);
        $total = $list->fetchSql(false)->count();
        $list = $list->field("id,name,account,email,status,is_super,login_ip,login_time,create_time,update_time")
            ->order($sortField, $sortBy)->page($page, $pageSize)->select();
        return success([
            'list' => $list,
            'total' => $total
        ], '获取信息成功');
    }

    //显示创建资源表单页
    public function create()
    {
        return 'create';
    }


    //显示指定的资源

    /**
     * @param int $id
     * @return \think\response\Json
     */
    public function read(int $id = 0)
    {
        $detail = (object)[];
        if ($id > 0) {
            $detail = get_admin_info($id);
            $detail['role'] = AdminRoleModel::where("admin_id", $id)->column("role_id");
        }
        //查询登录管理信息
        $adminId = $this->request->adminId;
        $admin = get_admin_info($adminId);
        //查询管理员拥有的角色
        $role = RoleModel::field("id,name");
        if (!$admin['is_super']) $role->where("admin_id", $adminId);
        $option['roleOption'] = $role->select();
        $option['statusOption'] = array_option(AdminModel::STATUS);
        return success([
            'detail' => $detail,
            'options' => $option
        ], '获取信息成功');
    }

    //显示编辑资源表单页
    public function edit($id)
    {
        return 'edit';
    }

    //保存新建的资源

    /**
     * @param Request $request
     * @return \think\response\Json
     */
    public function save(Request $request)
    {
        $param = $this->request->param();
        //验证器
        validate(\app\admin\validate\backstage\Admin::class)->scene('create')->check($param);
        $res = $this->creatOrUpdate($param, $request);
        return success($res, true);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return \think\response\Json
     */
    public function update(Request $request, int $id)
    {
        $param = $request->param();
        $noVerify = $request->param('noVerify', 0);
        //验证器
        if (!$noVerify) validate(\app\admin\validate\backstage\Admin::class)->scene('update')->check($param);
        $res = $this->creatOrUpdate($param, $request, $id);
        return success($res, true);
    }

    //删除指定资源

    /**
     * @apiDoc\Title("删除管理员")
     * @apiDoc\Desc("")
     * @apiDoc\Method("DELETE")
     * @Apidoc\Author("WHL")
     * @apiDoc\Url("/admin.php/backstage/admin/:id ")
     * @apiDoc\Param("id", type="int",require=true,desc="ID")
     * @param $id
     * @return \think\response\Json
     */
    public function delete(int $id)
    {
        if ($id == 1) return error('无法删除');
        Db::transaction(function () use ($id) {
            $res = AdminModel::where("admin_id", $id)->value("id");
            if ($res) return error('存在子级管理员,请删除后操作');
            $res = AdminModel::destroy($id);
            if ($res) {
                //删除关联角色
                AdminRoleModel::where("admin_id", $id)->delete();
                //删除创建的角色
                RoleModel::where("admin_id", $id)->delete();
            } else {
                return error();
            }
        });
        return success();
    }

    //新增或修改
    public function creatOrUpdate($data, $request, $id = 0)
    {
        if (isset($data['password']) && !empty($data['password'])) $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        //查重
        $account = $request->param('account', '');
        $isId = AdminModel::where("account", $account)->value("id");
        if ($isId && $isId != $id) return ['code' => 5000, 'message' => '账户已存在'];
        if ($id > 0) {
            $detail = AdminModel::find($id);
            if (!$detail) return ['code' => 5000, 'message' => '资源不存在'];
            $detail->save($data);
        } else {
            $data['admin_id'] = $request->adminId;
            $detail = AdminModel::create($data);
            $id = $detail['id'];
        }
        return ['code' => 2000, 'message' => '成功','data'=>$detail];
    }
}
