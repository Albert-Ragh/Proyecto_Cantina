<?php

class productosModel extends Model
{

    function __construct() {
        parent::__construct();
       // echo "contructor del modelo";
       // print "In SubClass constructor\n";
               //echo $this->conn->get_client_info();

    }
    public function getAllProducts() {

        $selectProductos = "SELECT * FROM PRODUCTO";

        $result = $this->conn->query($selectProductos);

        $productos = [];

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {

                $producto = new stdClass();

                $producto->id = intval($row["id_Producto"]);
                $producto->nom = $row["nom"];
                $producto->precio = floatval($row["precio"]);
                $producto->descripcion = $row["descripcion"];
                $producto->horario = intval($row["horario"]);
                $producto->url_Imagen = $row["url_Imagen"];
                $producto->stock = $row["stock"];
                $producto->activat = $row["activat"];
            
            
                $productos[] = $producto;
            }
        } else {
            echo "0 results";
        }

        return $productos;

    }

}
