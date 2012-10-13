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
            $this->json(Set::extract($this->paginate(), '{n}.Product'));
        } 
    }
}
