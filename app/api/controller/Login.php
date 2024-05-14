<?php

namespace app\api\controller;

use app\model\monument\QrCodeModel;
use hg\apidoc\annotation as Apidoc;

#[Apidoc\Title("登录注册")]
class Login extends Base
{
    #[
        Apidoc\Title("获取邮箱验证码"),
        Apidoc\Method("GET"),
        Apidoc\Url("/api/login/getCode"),
        Apidoc\Query(name: "email", type: "string", require: true, desc: "邮箱"),
        Apidoc\Query(name: "qr_code", type: "string", require: true, desc: "二维码"),
        Apidoc\Returned("code", type: "string", desc: "验证码"),
    ]
    public function getCode()
    {
        $email = $this->request->param('email', '');
        $qrCode = $this->request->param('qr_code', '');
        if (empty($email)) return error('邮箱不能为空');
        if (empty($qrCode)) return error('二维码不能为空');
        if (cache("email_code_{$email}_flag")) return error('请勿频繁发送验证码');

        $detail = QrCodeModel::where("code", $qrCode)->find();
        if (empty($detail)) return error('二维码不存在');
        if (time() > $detail['expiry_time']) return error('二维码已过期');

        $code = mt_rand(1000, 9999);

        cache("email_code_{$email}_flag", 1, 60);
        cache("email_code_{$email}", $code, 300);
        $detail->save(['activate_email' => $email]);
        return success(['code' => $code]);
    }

    #[
        Apidoc\Title("登录"),
        Apidoc\Method("POST"),
        Apidoc\Url("/api/login/login"),
        Apidoc\Param(name: "email", type: "string", require: true, desc: "邮箱"),
        Apidoc\Param(name: "qr_code", type: "string", require: true, desc: "二维码"),
        Apidoc\Param(name: "email_code", type: "int", require: true, desc: "邮箱验证码"),
        Apidoc\Param(name: "activate_code", type: "int", require: false, desc: "激活码"),
        Apidoc\Returned("token", type: "string", desc: "token"),
    ]
    public function login()
    {
        $email = $this->request->param('email', '');
        $emailCode = $this->request->param('email_code', '');
        $qrCode = $this->request->param('qr_code', '');
        $activateCode = $this->request->param('activate_code/d', 0);
        if (empty($email)) return error('邮箱不能为空');
        if (empty($emailCode)) return error('验证码不能为空');
        if (empty($qrCode)) return error('二维码不能为空');
        $code = cache("email_code_{$email}");
        if ($emailCode !== $code) return error('验证码不正确');

        $detail = QrCodeModel::where("code", $qrCode)->find();
        if (empty($detail)) return error('二维码不存在');
        if ($detail['activate_email'] !== $email) return error('邮箱不正确');
        if (time() > $detail['expiry_time']) return error('二维码已过期');
        if ($detail['activate_code'] !== $activateCode) return error('二维码已过期');
        if ($detail['is_init'] === 0) {
            if (empty($activateCode)) return error('激活码不能为空');
            if ($detail['activate_code'] !== $activateCode) return error('激活码正确');
            $detail->save(['is_init' => 1]);
        }


        return success([
            'token' => 'xxxxxxx'
        ]);
    }
}