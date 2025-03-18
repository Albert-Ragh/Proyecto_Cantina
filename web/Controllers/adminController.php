<?php
class adminController extends Controller
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

        if ($this->action == "") {
            View::render("admin");
        }

    }
}