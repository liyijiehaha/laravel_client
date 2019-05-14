<?php

namespace App\Http\Controllers\Reg;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class LoginController extends Controller
{
    public function reg(){
        return view('reg/reg');
    }
    public function regdo(Request $request){
        $email=$request->input('email');
        $pwd=$request->input('pwd');
        $repwd=$request->input('repwd');
        //检测密码是否一致
        if($pwd != $repwd){
            $reponse=[
                'errno'=>40001,
                'msg'=>'两次密码输入不一致',
            ];
            die(json_encode($reponse,JSON_UNESCAPED_UNICODE));
        }
        $email=DB::table('api_users')->where(['email'=>$email])->first();
        if($email){
            $reponse=[
                'errno'=>40003,
                'msg'=>'邮箱已存在',
            ];
            die(json_encode($reponse,JSON_UNESCAPED_UNICODE));
        }
        //密码加密处理
        $hash_pwd=password_hash($pwd,PASSWORD_DEFAULT);
        $data=[
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'pwd'=>$hash_pwd,
            'age'=>$request->input('age'),
            'sex'=>$request->input('sex'),
            'create_time'=>time()
        ];
        $res=DB::table('api_users')->insert($data);
        if($res){
            $json_str=json_encode($data);
            $k=openssl_pkey_get_private('file://'.storage_path('app/keys/private.pem'));
            openssl_private_encrypt($json_str,$enc_data,$k);
            $base64=base64_encode($enc_data);
            $url='http://1809.lumen_api.com/reg';
            $ch=curl_init();
            //设置curl
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$base64);
            curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:text/plain']);
            //抓取curl
            $res=curl_exec($ch);
            $code=curl_errno($ch);
            //关闭curl资源
            curl_close($ch);
        }else{
            //TODO
            $reponse=[
                'errno'=>40002,
                'msg'=>'添加失败',
            ];
            die(json_encode($reponse,JSON_UNESCAPED_UNICODE));
        }
    }
    public function ajax(){
        return view('ajax/ajax');
    }
}
