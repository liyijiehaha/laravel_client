<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
//    public $str='abc';
//    public  function decode(){
//        $offset=1;
//        $str=$this->str;
//
//    }
    protected $str0="holleworld";
    protected $method='AES-256-CBC';
    protected $key='xxyyzz';
    protected $option=OPENSSL_RAW_DATA;
    protected $iv='qwertyuiopasdfgh';
    public function encode(){
        $str0=$this->str0;
        $method=$this->method;
        $key=$this->key;
        $option=$this->option;
        $iv=$this->iv;
        $enc_str=openssl_encrypt($str0,$method,$key,$option,$iv);
        $base64=base64_encode($enc_str);
        echo '原文：'.$str0.'<hr>';
        echo '密文：'.$enc_str.'<hr>';
        echo 'base64密文：'.$base64.'<hr>';
    }
    public function decode(){
        $method=$this->method;
        $key=$this->key;
        $option=$this->option;
        $iv=$this->iv;
        $data=$_GET['str'];
        $d64=base64_decode($data);
        $dec_str=openssl_decrypt($d64,$method,$key,$option,$iv);
    }
    public  function code(){
        $method='AES-256-CBC';
        $key='xxyyzz';
        $option=OPENSSL_RAW_DATA;
        $iv='qwertyuiopasdfgh';
        $data=[
            'name'=>'liyijie',
            'age'=>'19',
            'cart_number'=>'1234567899874563'
        ];
        $data=json_encode($data);
        $enc_str=openssl_encrypt($data,$method,$key,$option,$iv);
        $base64=base64_encode($enc_str);
        $url='http://1809.lumen_api.com/code';
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
    }
    //非对称加密
    public function feicode(){
        echo __METHOD__.'<hr>';
        $data=[
            'name'=>'liyijie',
            'age'=>'19',
            'cart_number'=>'1234567899874563'
        ];
        //加密
        $json_str=json_encode($data);
        $k=openssl_pkey_get_private('file://'.storage_path('app/keys/private.pem'));
        openssl_private_encrypt($json_str,$enc_data,$k);
        var_dump($enc_data).'<hr>';
        //解密
        $jk=openssl_get_publickey('file://'.storage_path('app/keys/public.pem'));
        openssl_public_decrypt($enc_data,$dec_data,$jk);
        var_dump($dec_data).'<hr>';
    }
    public function fcode(){
        $data=[
            'name'=>'liyijie',
            'age'=>'19',
            'cart_number'=>'1234567899874563'
        ];
        //加密
        $json_str=json_encode($data);
        $k=openssl_pkey_get_private('file://'.storage_path('app/keys/private.pem'));
        openssl_private_encrypt($json_str,$enc_data,$k);
        $base64=base64_encode($enc_data);
        $url='http://1809.lumen_api.com/fcode';
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
    }

    public function testsign(){
        $data=[
            'oid'=>123456,
            'amount'=>2000,
            'title'=>'测试',
            'username'=>'fdsfsdf'
        ];
        $josn_str=json_encode($data);
        $k=openssl_get_privatekey('file://'.storage_path('app/keys/private.pem'));
        openssl_sign($josn_str,$signature,$k);
        $base64=base64_encode($signature);
        $url='http://1809.lumen_api.com/testsign?sign='.$base64;
        var_dump($url);
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
    }
}
