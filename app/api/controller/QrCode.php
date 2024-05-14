<?php

namespace app\api\controller;

use app\model\monument\QrCodeModel;

use hg\apidoc\annotation as Apidoc;

#[Apidoc\Title("二维码")]
class QrCode extends Base
{
    #[
        Apidoc\Title("根据二维码获取详情"),
        Apidoc\Tag(""),
        Apidoc\Method("GET"),
        Apidoc\Url("/api/qr_code/getDetail"),
        Apidoc\Query(name: "code", type: "string", require: true, desc: "二维码", mock: "@name"),
        Apidoc\Returned(ref: QrCodeModel::class),
    ]
    public function getDetail()
    {
        $code = $this->request->param('code', '');
        if (empty($code)) return error('二维码为空');
        $detail = QrCodeModel::where("code", $code)->find();
        if (empty($detail)) return error('查询不到信息');
        if ($detail['is_init'] === 0) return error('未激活');
        return success($detail);
    }
}

