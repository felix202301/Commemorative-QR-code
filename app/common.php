<?php
// 应用公共文件

if (!function_exists('success')) {
    /**
     * 请求成功返回
     * @param $data
     * @param $msg
     * @param $code
     * @return array|mixed
     */
    function success($data = [], $msg = '成功', $code = 2000)
    {
        if ($msg === true) {
            if (!isset($data['message'])) {
                $data['message'] = $data['msg'];
                unset($data['msg']);
            }
            $result = $data;
        } else {
            $result['code'] = $code;  // 状态码
            $result['message'] = $msg;   // 提示信息
            //$result['time'] = time(); // 请求返回时间
            $result['data'] = $data;  // 请求返回数据
        }
        return $result;
        //return json($result);
    }
}

if (!function_exists('error')) {
    /**
     * 请求失败返回
     * @param $msg
     * @param $code
     * @return array
     */
    function error($msg = '失败', $code = 5000)
    {
        $result['code'] = $code;
        $result['message'] = $msg;
        //$result['time'] = time();

        return $result;
        //return json($result);
    }
}

if (!function_exists('array_tree')) {
    /**
     * 以pid——id对应，生成树形结构
     * @param $array
     * @param string $pk
     * @param string $pid
     * @param string $child
     * @return array|bool
     */
    function array_tree($array, $pk = 'id', $pid = 'pid', $child = 'child')
    {

//        foreach($array as $k=>$v){
//            $refer[$v[$pk]]=&$array[$k];//为每个数组成员建立对应关系
//        }
//        //遍历2
//        foreach($array as $k=>$v){
//            $parent=&$refer[$v[$pid]];//获取父分类的引用
//            $parent[$child][]=&$array[$k];//在父分类的children中再添加一个引用成员
//        }
        $tree = [];     // 生成树形结构
        $newArray = []; // 中转数组，将传入的数组转换
        if (is_array($array) && !empty($array)) {
            foreach ($array as $item) {
                $newArray[$item[$pk]] = $item;  // 以传入数组的id为主键，生成新的数组
            }
            foreach ($newArray as $k => $val) {
                if ($val['pid'] > 0) {           // 默认pid = 0时为一级
                    $newArray[$val[$pid]][$child][] = &$newArray[$k];   // 将pid与主键id相等的元素放入children中
                } else {
                    $tree[] = &$newArray[$val[$pk]];   // 生成树形结构
                }
            }
            return $tree;
        } else {
            return false;
        }
    }
}
if (!function_exists('get_request_path')) {
    /**
     * 获取请求路由
     * @return string
     */
    function get_request_path()
    {
        $method = request()->method();
        $pathInfo = request()->pathinfo();
        return $method . ':/' . $pathInfo;
    }
}

if (!function_exists('alnum')) {
    /**
     * 随机生成数字+字母组合随机字符串密码盐（包含大小写字母）
     * @param int $len 生成随机字符串的长度，默认6个字符
     * @return false|string
     */
    function alnum($len = 6)
    {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($pool, ceil($len / strlen($pool)))), 0, $len);
    }
}

if (!function_exists('upload_file')) {
    /**
     * 保存上传文件
     * @param $file
     * @param string $file_path
     * @param array $validate
     * @return bool|string
     */
    function upload_file($file, $file_path = '', $validate = [])
    {
        $suffix = $file->extension();
        if (!$validate) {
            if (in_array($suffix, ['jpg', 'png', 'gif'])) {//图片
                $validate = ['fileSize:20971520,fileExt:gif,jpg,png'];
            } elseif (in_array($suffix, ['mp3'])) {//音乐
                $validate = ['fileSize:102400,fileExt:gif,jpg,png'];
            } elseif (in_array($suffix, ['mp4'])) {//视频
                $validate = ['fileSize:102400,fileExt:gif,jpg,png'];
            } else {
                return false;
            }
        }
        //文件验证
        $result = validate(['file' => $validate])->check(['file' => $file]);
        //保存文件
        $url = \think\facade\Filesystem::disk('public')->putFile($file_path, $file);
        $url = \think\facade\Filesystem::getDiskConfig('public', 'url') . '/' . str_replace('\\', '/', $url);
        //保存文件路径
        \app\model\t_base\UploadFileModel::create([
            'url' => $url,
            'suffix' => $suffix,
            'size' => $file->getSize(),
            'storage' => 1,
        ]);
        return $url;
    }
}

if (!function_exists('delete_upload_file')) {
    /**
     * 删除上传的文件
     * @param string $url
     * @return bool
     */
    function delete_upload_file($url = '')
    {
        if (!$url) return false;
        if (is_array($url)) {
            $dis = \app\model\t_base\UploadFileModel::whereIn("url", $url)->column("id");
        } else {
            $dis = \app\model\t_base\UploadFileModel::where("url", $url)->column("id");
        }
        return \app\model\t_base\UploadFileModel::destroy($dis);
    }
}

if (!function_exists('storage_unit_conversion')) {
    /**
     * 存储单位转换
     * @param int $size
     * @return string
     */
    function storage_unit_conversion($size = 0)
    {
        $unit = 'B';
        if ($size > 1023) {
            $unit = 'KB';
            $size = $size / 1024;
            if ($size > 1023) {
                $unit = 'MB';
                $size = $size / 1024;
                if ($size > 1023) {
                    $unit = 'GB';
                }
            }
        }
        return round($size) . $unit;
    }
}

