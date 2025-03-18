<?php
class comandasController extends Controller
{
    protected $data = array();
    protected $model = null;

    public function loadDb()
    {
        $this->model = Model::getInstance("comandas");
    }
    public function doAction()
    {
        if ($this->action == "fetchComandas") {
            $this->data["comandas"] = $this->model->getAllComandas();
        }
        else if($this->action == "fetchLineasComanda") {
            $this->data["lineasComanda"] = $this->model->getAllLineasComanda();
        }
        else if($this->action == "updateFet"){

            $request_body = file_get_contents('php://input');

            $data = json_decode($request_body);

            $id = intval($data->id);
            $fet = intval($data->num);

            $user = $this->model->updateFet($id, $fet);
           
            if($fet == 1){ 

                $to = $user->correuClient;
                $subject = "Tu pedido de la Cantina Pedralbes esta en marcha!";
                $message = "Hola señor/a " . $user->nomClient . "\n\n Queriamos informarle de que su pedido " . $id . " ya esta listo y puede pasar a recogerlo. \n \n Saludos" ;
                $headers = "From: cantina4@inspedralbes.cat";
    
                mail($to, $subject, $message, $headers);
    
            }else{
                
                $to = $user->correuClient;
                $subject = "Hay un problema con tu pedido.";
                $message = "Hola señor/a " . $user->nomClient . "\n\n Queriamos informarle de que su pedido " . $id . " aun no esta listo y ha ocurrido un error. \n \nPerdone las molestias" ;
                $headers = "From: cantina4@inspedralbes.cat";
    
                mail($to, $subject, $message, $headers);
            }


        }
        else if ($this->action == "updateDades") {

            $request_body = file_get_contents('php://input');

            $data = json_decode($request_body);

            $textCampSelect = $data->textCampSelect;
            $textProdSelect = $data->textProdSelect;
            $textValor = $data->textValor;

            $this->model->updateDades($textProdSelect, $textCampSelect, $textValor);
        }
        else if ($this->action == "updateActivo") {
            $request_body = file_get_contents('php://input');

            $data = json_decode($request_body);

            $id = intval($data->id);
            $activo = intval($data->num);

            $this->model->updateActivo($id, $activo);
        }
    }
    public function render() {

        // if ($this->action == "fetchMenu") {
        //     View::render("menu", $this->data);
        // } 
    }
    public function fetch() {

        if ($this->action == "fetchComandas") {
            View::fetch("comandas", $this->data);
        } 
        else if ($this->action == "updateFet") {
            View::fetch("updateFet");
        }
        else if ($this->action == "updateDades") {
            View::fetch("updateDades");
        }
        else if ($this->action == "updateActivo") {
            View::fetch("updateActivo");
        }
    }
}
