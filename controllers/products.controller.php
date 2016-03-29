<?php

class ProductsController extends Controller
{

    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new Product();
    }

    //Сам запилил Продукты(
    public function index()
    {
        $this->data['product'] = $this->model->getProduct();
    }

    public function product_id()
    {
        $params = App::getRouter()->getParams();

        if (isset($params[0])) {
            $id = strtolower($params[0]);
            $this->data['product'] = $this->model->getByProductId($id);
        }
    }    //Сам запилил Продукты)

    public function admin_index(){

        $this->data['product'] = $this->model->getProduct();
    }


    public function admin_add(){
        if ( $_POST ){
            $result = $this->model->save($_POST);
            if ( $result ){
                Session::setFlash('Товар добавлен!');
            }else{
                Session::setFlash('Ошибка!');
            }
            Router::redirect('/admin/products/');
        }
    }

    public function admin_edit(){
        if ( $_POST ){
            $id = isset($_POST['id']) ? $_POST['id'] : null;
            $result = $this->model->save($_POST,$id);
            if ( $result ){
                Session::setFlash('Товар отредактирован!');
            }else{
                Session::setFlash('Ошибка.');
            }
            Router::redirect('/admin/products/');
        }
        if ( isset($this->params[0]) ){
            $this->data['product'] = $this->model->getByProductId($this->params[0]);
        }else{
            Session::setFlash('Неправильный id.');
            Router::redirect('/admin/products/');
        }
    }

    public function admin_delete(){
        if ( isset($this->params[0])){
            $result = $this->model->delete($this->params[0]);
            if ( $result ){
                Session::setFlash('Товар удален!');
            }else{
                Session::setFlash('Ошибка!');
            }
        }
        Router::redirect('/admin/products/');
    }
}



/*


}

  /* public function_construct($data = array() )
   {
       parent::__construct($data);
       $this->model = new Product();
   }

   public function product(){
       $this->data['product'] = $this->model->getProduct();
   }

  public function view(){
       $params = App::getRouter()->getParams();

       if( isset($params[0])){
           $name = strtolower($params[0]);
           $this->data['product'] = $this->model->getByName($name);
       }
   }

}*/