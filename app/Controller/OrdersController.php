<?php
App::uses('AppController', 'Controller');
/**
 * Orders Controller
 *
 * @property Order $Order
 */
class OrdersController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Order->recursive = 0;
        $this->set('orders', $this->paginate());
    }

    public function order() {
        $_data = array();
        $_code = 405;

        if ( $this->request->is('post') && $this->request->is("ajax") ) {
            $_fields = array(
                'product_id',
                'name',
                'telephone',
                'email',
                'postal',
                'address',
                'note',
            );

            $_params = $this->params_filter($_fields, $this->request->data);
            $_product_id = isset($_params['product_id']) ? intval($_params['product_id']) : 0;
            $_name = isset($_params['name']) ? trim($_params['name']) : '';
            $_telephone = isset($_params['telephone']) ? trim($_params['telephone']) : '';
            $_email = isset($_params['email']) ? trim($_params['email']) : '';
            $_postal = isset($_params['postal']) ? trim($_params['postal']) : '';
            $_address = isset($_params['address']) ? trim($_params['address']) : '';
            $_note = isset($_params['note']) ? trim($_params['note']) : '';

            do {
                if ( $_product_id < 1) {
                    $_code = 20004;
                    break;
                }

                if ( !$_address ) {
                    $_code = 2005;
                    break;
                }

                App::uses('Validation', 'Utility');

                if ( !Validation::notEmpty($_name) ) {
                    $_code = 2000;
                    break;
                }

                if ( !Validation::phone($_telephone) ) {
                    $_code = 2001;
                    break;
                }

                if ( !Validation::email($_email) && !Validation::custom($_email, '/^[0-9]{5,11}$/') ) {
                    $_code = 2002;
                    break;
                }

                if ( !Validation::postal($_postal, '/^[0-9]{6}$/') ) {
                    $_code = 2003;
                    break;
                }

                $_source_ip = $this->request->clientIp();

                $_key = Configure::read("Server.secure");
                $_order_api = Configure::read('Server.order_api');
                $_sign = strtolower(md5(sprintf("%s_%s_%s", $_product_id, $_source_ip, $_key)));

                App::uses('HttpSocket', 'Network/Http');
                $_post_data = array(
                    'name' => $_name,
                    'email' => $_email,
                    'telephone' => $_telephone,
                    'postal' => $_postal,
                    'address' => $_address,
                    'product_id' => $_product_id,
                    'note' => $_note,
                    'source_ip' => $_source_ip,
                    'sign' => $_sign
                );
                $_client = new HttpSocket();
                $_callback = $_client->post($_order_api, $_post_data);
                 
                if ( !$_callback ) {
                    $_code = 408;
                    break;
                }

                $_callback = json_decode($_callback->body(), true);
                $_error_code = intval($_callback['code']);

                if ( $_error_code ) {
                    $_code = $_error_code;
                    break;
                }

                $_code = 0;
            } while(0);
        } 

        $this->json($_data, $_code);
    }

    /**
     * add method, web service
     *
     * @return void
     */
    public function add() {
        $_code = 405;
        $_result = false;

        if ( $this->request->is('post') ) {
            $_fields = array(
                'product_id',
                'name',
                'telephone',
                'email',
                'postal',
                'address',
                'note',
                'source_ip',
                'sign',
            );

            $_params = $this->params_filter($_fields, $this->request->data);
            $this->sign_verify(array('product_id', 'source_ip'), $_params); 

            do {
                $_need_fields = array('product_id', 'name', 'telephone', 'email', 'postal', 'address', 'source_ip');
                $this->params_verify($_need_fields, $_params);
                $_product_id = intval($_params['product_id']);
                $_name = trim($_params['name']);
                $_telephone = trim($_params['telephone']);
                $_email = trim($_params['email']);
                $_postal = trim($_params['postal']);
                $_address = trim($_params['address']);
                $_note = isset($_params['note']) ? trim($_params['note']) : '';
                $_source_ip = trim($_params['source_ip']);
                $_code = 600;
                App::uses('Validation', 'Utility');
                
                if ( $_product_id < 1) break;

                if ( !Validation::notEmpty($_name) ) break;

                if ( !Validation::phone($_telephone) ) break;

                if ( !Validation::email($_email) && !Validation::custom($_email, '/^[0-9]{5,11}$/') ) break;

                if ( !Validation::postal($_postal, '/^[0-9]{6}$/') ) break;

                if ( !Validation::notEmpty($_address) ) break;

                if ( !Validation::ip($_source_ip) ) break;

                $this->loadModel('Product');
                $this->Product->id = $_product_id;
                $_product_name = $this->Product->field('product_name');

                if ( !$_product_name ) break;

                $_order_data = array(
                    'product_id' => $_product_id,
                    'product_name' => $_product_name,
                    'customer_realname' => $_name,
                    'customer_telephone' => $_telephone,
                    'customer_email' => $_email,
                    'customer_postal' => $_postal,
                    'customer_address' => $_address,
                    'customer_note' => $_note,
                    'customer_ip' => $_source_ip
                );

                $this->Order->create();

                if ( $this->Order->save($_order_data) ) {
                    $_code = 0;
                    $_result = true;
                } else {
                    $_code = 601;
                }

            } while(0);
        }

        $this->json($_result, $_code);
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        if ( $this->request->is('post') ) {
            $_params = $this->request->data;
            $_sort = isset($_params['sort']) ? trim($_params['sort']) : 'id';
            $_order = isset($_params['order']) ? trim(strtolower($_params['order'])) : 'desc';
            $_sort_fields = array('id', 'product_name', 'created', 'updated');

            if ( !in_array($_sort, $_sort_fields) ) $_sort = 'id';
            if ( !in_array($_order, array('desc', 'asc')) ) $_order = 'desc';

            $_paginate = $this->paginate;
            $_paginate = array_merge($_paginate, array('order'=>array(sprintf('Order.%s', $_sort) => $_order)));
            $this->paginate = $_paginate;
            $this->json(Set::extract($this->paginate(),'{n}.Order'), 0, array('total'=>$this->Order->find('count')));
        } 
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        //$this->layout = 'default';
        $this->Order->id = $id;
        if (!$this->Order->exists()) {
            throw new NotFoundException(__('Invalid order'));
        }
        $this->set('order', $this->Order->read(null, $id));
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        //$this->layout = 'default';
        $this->Order->id = $id;
        if (!$this->Order->exists()) {
            throw new NotFoundException(__('Invalid order'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Order->save($this->request->data)) {
                $this->Session->setFlash(__('The order has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The order could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Order->read(null, $id);
        }
    }

    /**
     * admin_delete method
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        //$this->layout = 'default';
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Order->id = $id;
        if (!$this->Order->exists()) {
            throw new NotFoundException(__('Invalid order'));
        }
        if ($this->Order->delete()) {
            $this->Session->setFlash(__('Order deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Order was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
}
