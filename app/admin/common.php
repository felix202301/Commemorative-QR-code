<?php
// 这是系统自动生成的公共文件

if (!function_exists('get_admin_info')) {
    /*
     * 获取登录管理员信息
     * @param int $admin_id
     * @return array
     */
    function get_admin_info($adminId = 0)
    {
        if ($adminId) {
            $admin = \app\admin\model\t_base\AdminModel::withoutField("password")->find($adminId);
            if ($admin) return $admin->toArray();
        }
        return [];
    }
}

if (!function_exists('get_routing')) {
    /*
     * 获取登录管理员权限信息
     * @param int $adminId
     * @param int $isSuper
     * @param int $isPath
     * @return array
     */
    function get_routing($adminId = 0, $isSuper = 0, $isPath = 0)
    {
        if ($isSuper) {
            $list = app\model\t_base\RoutingModel::field("id,name,path,pid,status")->select();
        } else {
            $list = app\model\t_base\AdminRoleModel::alias("a")->join("role_routing b", "a.role_id=b.role_id")
                ->join("routing c", "b.routing_id=c.id")->where("a.admin_id", $adminId)->where("c.status", 1)
                ->tableField("id,name,path,pid,status", "c")->fetchSql(false)->select();
        }
        if ($isPath) {
            $list2 = [];
            foreach ($list as $k => $v) {
                $list2 = array_merge($list2, explode("\n", $v['path']));
            }
            return $list2;
        }
        return $list->toArray();

    }
}
if (!function_exists('array_option')) {
    /**
     * 关联数组转前端select选项数组
     * @param array $array
     * @return array
     */
    function array_option($array = [])
    {
        if ($array) {
            $option = [];
            foreach ($array as $k => $v) {
                $option[] = ['label' => $v, 'value' => $k,];
            }
            return $option;
        }
        return $array;
    }
}


