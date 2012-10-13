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


    /**
     * 后面用户列表
     * @name POST:/admin/users
     * @author Will.Xu
     **/
    public function admin_index(){
        if ( $this->request->is('post') ) {
            $_params = $this->request->data;
            $_sort = isset($_params['sort']) ? trim($_params['sort']) : 'id';
            $_order = isset($_params['order']) ? trim(strtolower($_params['order'])) : 'desc';
            $_sort_fields = array('id', 'name', 'operate', 'created', 'nickname');

            if ( !in_array($_sort, $_sort_fields) ) $_sort = 'id';
            if ( !in_array($_order, array('desc', 'asc')) ) $_order = 'desc';

            $_paginate = $this->paginate;
            $_paginate = array_merge($_paginate, array('sort'=>sprintf('User.%s %s',$_sort, $_order)));
            $this->paginate = $_paginate;
            $this->json(Set::extract($this->paginate(),'{n}.User'), 0, array('total'=>$this->User->find('count')));
        } 
    }

    /**
     * 更改管理员信息
     * @name POST:/admin/users/update
     * @author Will.Xu
     **/
    public function admin_update(){
        $_data = false;
        $_code = 403;

        if ( $this->request->is('post') && $this->request->is("ajax") ) {
            $_fields = array('field', 'value', 'id');
            $_params = $this->params_filter($_fields, $this->params->data);
            $this->params_verify($_fields, $_params );
            $_code = 600;
            $_id = intval($_params['id']);
            $_field = trim($_params['field']);
            $_value = trim($_params['value']);
            $_update_fields = array('nickname');

            do {
                if ( $_id < 1) break;
                if ( !in_array($_field, $_update_fields) ) break;
                if ( strlen($_value) < 5 ) break; 

                $_update_data = array('id'=>$_id, $_field=>$_value, 'operate'=>$this->user['name']);

                if ($this->User->save($_update_data) ) {
                    $_data = true;
                    $_code = 0;
                } else {
                    $_code = 601;
                }
            } while(0);

        }

        $this->json($_data, $_code);
    }

    /**
     * 删除管理员
     * @name POST:/admin/users/delete
     * @author Will.Xu
     **/
    public function admin_delete(){
        $_data = false;
        $_code = 403;
        
		if ( $this->request->is('post') ) {
			$_params = $this->params_filter(array('id'), $this->request->data);

			do {
				if ( !count($_params) ) {
					$_code = 400;
					break;
				}

				$_id = $_params['id'];
				$_id = explode(',', $_id);
				$_id = array_map('intval', $_id);

				if ( !count($_id) ) {
					$_code = 406;
					break;
				}

				if ($this->User->deleteAll(array('User.id'=>$_id))){
					$_code = 0;
					$_data = true;
				} else {
					$_code = 601;
				}
			} while(0);
		}

		$this->json($_data, $_code);
    }

    /**
     * 添加管理员 
     * @name POST:/admin/users/add
     * @author Will.Xu
     **/
    public function admin_add() {
        $_code = 403;
        $_data = false;

        if ( $this->request->is('post') ) {
			$_params_fields = array('username', 'password');
			$_params = $this->params_filter($_params_fields, $this->request->data);
			$this->params_verify($_params_fields, $_params);
			$_username = trim($_params['username']);
			$_password = trim($_params['password']);

			do {
				$_code = 406;

				if ( strlen($_username) < 4 ) break;

				if ( !$_password ) break;

				App::uses('Password', 'Vendor');
				$_password = Password::getPassword($_password);

				$_count = $this->User->find("count", array("conditions"=>array('User.name'=>$_username)));

				if ( $_count ) {
					$_code = 1004;
					break;
				}

				$_post_data = array('name'=>$_username, 'nickname'=>$_username, 'password'=>$_password, 'operate'=>$this->user['name']);
				$this->User->create();

				if ($this->User->save($_post_data)) {
					$_code = 0;
					$_data = true;
				} else {
					$_code = 601;
				}

			} while(0);

        }

        $this->json($_data, $_code);
    }
}
