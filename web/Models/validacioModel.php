<?php

class validacioModel extends Model
{

    function __construct()
    {
        parent::__construct();
        // echo "contructor del modelo";
        // print "In SubClass constructor\n";
        //echo $this->conn->get_client_info();

    }
    public function selectsInserts()
    {

        $hidden = $_POST['comanda'];
        $nomClient = $_POST['fname'];
        $tlfClient = $_POST['telefono'];
        $correoClient = $_POST['correu'];
        $comandaComent = $_POST['comentariComanda'];

        $obj = json_decode($hidden);

        $preuTotal = 0;

        // Check connection
        if ($this->conn->connect_error) {

            die("Connection failed: " . $this->conn->connect_error);
        }

        // echo " Connected successfully ";

        //Selecciona el id de la comanda
        $sql = "SELECT * FROM COMANDA WHERE id_Comanda = ( SELECT MAX(id_Comanda) FROM COMANDA)";

        $result = $this->conn->query($sql);

        $result = $result->fetch_array();

        if (isset($result)) {
            $idComanda = intval($result[0]) + 1;
        } else {
            $idComanda = 1;
        }

        $date = new DateTime();
        $currentDate = $date->format('Y-m-d');
        // echo $idComanda;

        $sqlVerifica = "SELECT * FROM COMANDA";

        $resultat = $this->conn->query($sqlVerifica);

        $repetido = FALSE;

        while ($valores = mysqli_fetch_array($resultat)) {

            if ($valores["correu_client"] == $correoClient && $valores["data_Comanda"] == $currentDate) {
                $repetido = TRUE;
            }
        }

        if ($repetido == FALSE) {



            //Hace el insert en comanda sin el precio toal
            $sqlInsertComanda = "INSERT INTO COMANDA VALUES ($idComanda, FALSE, null, '$currentDate', '$nomClient', $tlfClient, '$correoClient', '$comandaComent')";


            if ($this->conn->query($sqlInsertComanda) === TRUE) {
                // echo "New record created successfully";
            } else {
                // echo "Error: " . $sql . "<br>" . $this->conn->error;
            }


            //Por cada producto seleccionado lo inserta en linea_Comanda
            foreach ($obj as $producto) {

                //Selecciona los precios de los produtos y los suma todos
                $sqlPreuProd = "SELECT precio FROM PRODUCTO WHERE id_Producto = $producto->id";
                $resultPreu = $this->conn->query($sqlPreuProd);
                $resultPreu = $resultPreu->fetch_array();

                $preuProd = floatval($resultPreu[0]);
                // echo $preuProd;
                $preuProducteTotal = $preuProd * $producto->cantidad;

                $preuTotal += $preuProducteTotal;

                //Inserta los productos de la comanda el la bd
                $sqlInsertCom_Linea = "INSERT INTO LINEA_COMANDA VALUES (null, $idComanda, $producto->id, $producto->cantidad, $preuProd)";

                if ($this->conn->query($sqlInsertCom_Linea) === TRUE) {
                    // echo "New record created successfully";
                } else {
                    // echo "Error: " . $sql . "<br>" . $this->conn->error;
                }

                $sqlUpdateStock = "UPDATE PRODUCTO SET stock = ((SELECT stock FROM PRODUCTO WHERE id_Producto = $producto->id) - $producto->cantidad) WHERE id_Producto = $producto->id";

                if ($this->conn->query($sqlUpdateStock) === TRUE) {
                    // echo "New record created successfully";
                } else {
                    // echo "Error: " . $sql . "<br>" . $this->conn->error;
                }
            }

            //Actualiza el precio total
            $sqlUpdatePreu = "UPDATE COMANDA SET preu_Total = $preuTotal WHERE id_COMANDA = $idComanda";

            if ($this->conn->query($sqlUpdatePreu) === TRUE) {
                // echo "New record created successfully";
            } else {
                // echo "Error: " . $sql . "<br>" . $this->conn->error;
            }
            //Coge el dia actual

            $to = $correoClient;
            $subject = "Tu pedido de la Cantina Pedralbes esta en marcha!";
            $message = "Hola señor/a " . $nomClient . "\n\nQueriamos informarle de que su pedido con id " . $idComanda . " se ha realizado correctamente. \n \nSaludos" ;
            $headers = "From: cantina4@inspedralbes.cat";

            mail($to, $subject, $message, $headers);
        }
        return $repetido;
    }
}
