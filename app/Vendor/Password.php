<?php

class Password {

    /**
     * 生成密码
     * @param string  $password 原始密码,必选
     * @return string 生成后的密码
     * @author Will.Xu
     **/
    public static function getPassword($password) {
        $_key = Configure::read('Password.salt');
        return md5(sprintf("%s_%s", $_key, $password));
    }


    /**
     * 检验密码 
     * @param string  $password 原始密码,必选
     * @param string  $secult_password 加密后的密码,必选
     * @return boolean 
     * @author Will.Xu
     **/
    public static function passwordVerify($password, $securt_password) {
        $password = self::getPassword($password);
        return $password == $securt_password;
    }
}

