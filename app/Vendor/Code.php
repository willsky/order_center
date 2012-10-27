<?php
/**
 * Response Error code to Message for multi-language
 **/

class Code {

    /**
     * 根据状态码，返回错误信息,支持国际化
     * code状态码的函义
     * 4xx: 请求类错误
     * 5xx: 服务器端错误
     * 6xx: 预留错误，后面定义
     * 10xx: 密码相关
     **/
    public static function msg($code) {
        $_codes = array(
            0 => __('Success'),
            400 => __('Miss paramter'),
            401 => __('No Auth'),
            402 => __('Sign Fail'),
            403 => __('Request deny'),
            404 => __('Not Found'),
            405 => __('Request method error'),
            406 => __('Bad Request'),
            408 => __('Timeout'),
            500 => __('Server Error'),
            501 => __('Request method not support'),
            600 => __('Paramter value error'),
            601 => __('Save fail'),
            1000 => __('Password error'),
            1001 => __('username is null'),
            1002 => __('password is null'),
            1003 => __('Account not exist'),
            1004 => __('Account exist'),
            1005 => __('Can Not Delete admin'),
            2000 => __('Name can not empty'),
            2001 => __('Telephone wrong'),
            2002 => __('Email wrong'),
            2003 => __('Postal wrong'),
            2004 => __('Miss product id'),
            2005 => __('Address wrong'),
        );
        return $_codes[$code];
    }
}

