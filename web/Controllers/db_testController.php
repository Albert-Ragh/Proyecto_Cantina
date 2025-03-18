<?php
class db_testController extends Controller
{
    protected $data = array();
    protected $model = null;

    public function loadDb()
    {
        $this->model = Model::getInstance("db_test");
    }
    public function doAction()
    {
        if ($this->action == "select") {
            $this->data["allUsers"] = $this->model->getAllUsers();
        }
    }
    public function render()
    {
        //echo $this->controller;
        //echo "<br>render  from index!!!<br>";

        if ($this->action == "select") {
            View::render("db_test/db_test_select", $this->data);
        } else if ($this->action == "insert") {
            View::render("db_test/db_test_insert");
        } else if ($this->action == "update") {
            View::render("db_test/db_test_update");
        } else if ($this->action == "delete") {
            View::render("db_test/db_test_delete");
        } else {
            View::render("404");
        }
    }
}
