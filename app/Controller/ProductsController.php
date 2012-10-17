<?php
App::uses('AppController', 'Controller');
/**
 * Products Controller
 *
 * @property Product $Product
 */
class ProductsController extends AppController {


    /**
     * 后台产品列表
     * @name POST:/admin/Products/index
     * @author Will.Xu
     **/
    public function admin_index(){
        if ( $this->request->is('post') ) {
            $_params = $this->request->data;
            $_sort = isset($_params['sort']) ? trim($_params['sort']) : 'id';
            $_order = isset($_params['order']) ? trim(strtolower($_params['order'])) : 'desc';
            $_sort_fields = array('id', 'product_name');

            if ( !in_array($_sort, $_sort_fields) ) $_sort = 'id';
            if ( !in_array($_order, array('desc', 'asc')) ) $_order = 'desc';

            $_paginate = $this->paginate;
            $_paginate = array_merge($_paginate, array('sort'=>sprintf('Product.%s %s',$_sort, $_order)));
            $this->paginate = $_paginate;
            $this->json(Set::extract($this->paginate(),'{n}.Product'), 0, array('total'=>$this->Product->find('count')));
        } 
    }
}
