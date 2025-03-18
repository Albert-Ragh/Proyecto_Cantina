<?php
class IndexController extends Controller
{
    protected $data = array();

    public function loadDb()
    {
        //echo "DB loaded [from index]!!<br>";
    }
    public function doAction()
    {
        //echo "<hr>do action  [from index]!!!<br>";
    }
    public function render()
    {
        //echo $this->controller;
        //echo "<br>render  from index!!!<br>";
        $this->data["arrayTest"] = array("first" => "yes", "second" => "no");

        if ($this->action == "") {
            View::render("index", $this->data);
        } else if ($this->action == "admin") {

            $this->data["role"] = "admin";
            View::render("index", $this->data);
        } else {
            View::render("404");
        }
    }
}
