<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {


    /**
     * 用户登录验证
     * @name POST:/login
     * @param string $username
     * @param string $password
     * @author Will.Xu
     **/
    public function signIn() {
        $_code = 405;
        $_result = false;

        if ( $this->request->is('post') && $this->request->is('ajax') ) {
            $this->loadModel('User');
            App::uses('Password', 'Vendor');
            $_fields = array('username', 'password');
            $_params = $this->params_filter($_fields, $this->params['data']);
            $this->params_verify($_fields, $_params);
            $_username = trim($_params['username']);
            $_password = trim($_params['password']);

            do {
                if ( empty($_username) ) {
                    $_code = 1001;
                    break;
                }

                $_user_info = $this->User->findByName($_username, array('id', 'name', 'nickname', 'password'));

                if ( !$_user_info ){
                    $_code = 1003;
                    break;
                }

                $_user_info = $_user_info['User'];
                $_securt_password = $_user_info['password'];

                if ( Password::passwordVerify($_password, $_securt_password) )
                {
                    $_result = true;
                    unset($_user_info['password']);
                    $this->Session->write('User.Info', $_user_info);
                    $_code = 0;
                } else 
                    $_code = 1000;

            } while(0);
        }

        $this->json($_result, $_code);
    }


    /**
     * 用户退出系统
     * @name POST:/login
     * @param string $username
     * @param string $password
     * @author Will.Xu
     **/
    public function admin_logout(){
        $this->Session->delete('User.Info');
        $this->redirect('/login');
    }

}
