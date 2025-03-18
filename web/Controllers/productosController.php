<?php
class productosController extends Controller
{
    protected $data = array();
    protected $model = null;

    public function loadDb()
    {
        $this->model = Model::getInstance("productos");
    }
    public function doAction()
    {
        if ($this->action == "fetchProductos") {
            $this->data["productos"] = $this->model->getAllProducts();
        }
    }
    public function render() {

        // if ($this->action == "fetchMenu") {
        //     View::render("menu", $this->data);
        // } 
    }
    public function fetch() {

        if ($this->action == "fetchProductos") {
            View::fetch("productos", $this->data);
        } 
    }
}
