<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array('Session');

    public $helpers = array('Session');

    protected $user = null;
    protected $uid = 0;

    /**
     * 初始化工作
     **/
    public function beforeFilter(){
        $this->set('title_for_layout', __('Orders Manage Center'));
        $this->layout = 'service';
        $_action  = $this->request->params['action'];

        if ( 'admin_' == substr($_action, 0, 6) ) {
            $this->_login_verify();
        }
    }

    /**
     * 用户登录验证
     **/
    private function _login_verify() {

        $_user = $this->Session->read('User.Info');

        if ( $_user ) {
            $this->user = $_user;
            $this->uid = $_user['id'];
        } else { 
            if ( $this->request->is('ajax') ) {
                $this->json(false, 401);
            } else {
                $this->redirect('/admin/login');
            }
        }
    }

    /**
     * 签名验证, 签名失败，则直接返回非法请求的结果
     * @param Array $fields 参数签名的字段, 有顺序
     **/ 
    protected function sign_verify($fields, $params, $return=false){
        $_sign = false;

        do {
            $_fields = $fields;
            array_push($fields, 'sign');

            if ( $return ) {
                if ( !$this->params_verify($fields, $params, true) ){
                    break;
                }
            } else 
                $this->params_verify($fields, $params);

            unset($fields);
            $_key = Configure::read('Server.secure');
            $_sign_value = strtolower(trim($params['sign']));
            $_values = array_values($this->params_filter($_fields, $params));
            array_push($_values, $_key);
            $_values = implode('_', $_values);

            if ( $_sign_value == strtolower(md5($_values)) ) {
                $_sign = true;
            }

        } while(0);

        if ( $return ) {
            return $_sign;
        } else  if ( !$_sign ) {
            $this->json(false, 402);
        }
    }

    /**
     * 输入json格式数据
     * @param Array $data 输出的数据
     **/
    protected function json($data=array(), $code = 0, $append=array()){
        $this->autoLayout = false;
        $this->autoRender = false;
        App::uses('Code', 'Vendor');
        header('Content-Type: application/json');
        $_data = array('code' => $code, 'msg' => Code::msg($code), 'data' => $data);

        if ( is_array($append) && count($append) )
            $_data = array_merge($_data, $append);

        echo json_encode($_data);
        $this->response->send();
        exit;
    }

    /**
     * 过滤参数
     **/
    protected function params_filter($fields, $params) {
        $_filters = array();

        foreach($fields as $_key) {
            if ( array_key_exists($_key, $params) ) {
                $_filters[$_key] = $params[$_key];
            } 
        }

        return $_filters;
    }

    /*
     * 检测必传参数是否丢失
     **/
    protected function params_verify($fields, $params, $return=false){
        $_ismiss = false;

        foreach ($fields as $_key) {
            if ( !isset($params[$_key]) ) {
                $_ismiss = true;
                break;
            }
        }

        if ( $return ) {
            return !$_ismiss;
        } else if ($_ismiss) {
            $this->json(false, 400);
        }
    }

    public function beforeRender() {
        if ( 'CakeError' == $this->name && !intval(Configure::read("debug")) ) {
            if ( $this->request->is('ajax') ) {
                $this->json(false, 500);
            } else {
                $this->redirect("/error");
            }
        }
    }

    protected function parserQuery($query)
    {
        $_query = array();

        $_params = explode('|', $query);

        foreach($_params as $_param) {
            $_item = explode(':', $_param);

            if ( 2 != count($_item) ) {
                continue;
            }
            list($_key, $_value) = $_item;

            $_query[$_key] = $_value;
        }

        return $_query;
    }
}

