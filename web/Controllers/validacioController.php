<?php
class validacioController extends Controller
{
    protected $data = array();

    public function loadDb()
    {
        $this->model = Model::getInstance("validacio");
    }
    public function doAction() {

        $checkName = $this->checkName();
        $checkEmail = $this->checkEmail();
        $checkTel = $this->checkPhone();

        $this->data["correcto"] = false;

        if($checkName && $checkEmail && $checkTel) {
            if ($this->action == "") {
                $this->data["correcto"] = $this->model->selectsInserts();
            }
        }


        
    }
    public function render()
    {
        //echo $this->controller;
        //echo "<br>render  from index!!!<br>";

        if ($this->action == "") {
            View::render("validacio", $this->data);
        }

    }

    private function checkName() {
        
        $nombre = $_POST['fname']; 
        $checkName = false;

        if (isset($nombre)){
            if (!preg_match ("/^[a-zA-z]*$/", $nombre) ) {  
                // $ErrMsg = "Only alphabets and whitespace are allowed.";  
                // echo $ErrMsg;  
            } else {  
                // echo $nombre;
                $checkName = true;  
            }
        }
        return $checkName;
    }

    private function checkEmail() {
        
        $correo = $_POST['correu']; 
        $checkEmail = false;

        $pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@inspedralbes.cat^";

        if (!preg_match ($pattern, $correo) ){  
            // $ErrMsg = "Email is not valid. ";  
            // echo $ErrMsg;  
            
        } else {  
            // echo " Your valid email address is: " .$correo   ;
            $checkEmail = true;  
        }  

        return $checkEmail;
    }

    private function checkPhone() {
        
        $telefono = $_POST['telefono'];
        $checkTel = false;

        if(!preg_match('/^[0-9]{9}+$/', $telefono)) {
            // $ErrMsg = " Only numeric value is allowed. ";  
            // echo $ErrMsg;  
        } else {
            // echo $telefono;
            $checkTel = true;
        }

        return $checkTel;
    }
}