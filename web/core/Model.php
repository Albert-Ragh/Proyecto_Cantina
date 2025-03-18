<?php

class Model
{
    /**
     * @var object
     */
    protected $conn;

    /**
     * Inicializa conexion
     */
    public function __construct()
    {
        global $MODEL;

        //echo "constructor del modelo padre";

        $this->conn = new mysqli(
            $MODEL->HOST,
            $MODEL->USER,
            $MODEL->PASSWORD,
            $MODEL->DB_NAME
        );
        if ($this->conn->connect_error) {
            echo "ERROR: Connection failed" . $this->conn->connect_error;
        }
        //echo $this->conn->get_client_info();
    }

    /**
     * Finaliza conexion
     */
    public function __destruct()
    {
        $this->conn->close();
    }

    public static function getInstance($modelName)
    {
        //if file exist?
        $m = null;
        $className = $modelName . "Model";
        require_once("Models/" . $className . ".php");
        if (class_exists($className)) {
            //echo "LOAD Model";
            //echo "class exists";
            $m = new $className();
        } else {
            // new View("404", "Controlador no trobat")->render();
            //echo "Controlador no trobat";
            //echo "class does not exists";
        }
        return $m;
    }
}
