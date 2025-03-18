<?php

class comandasModel extends Model
{

    function __construct()
    {
        parent::__construct();
        // echo "contructor del modelo";
        // print "In SubClass constructor\n";
        //echo $this->conn->get_client_info();

    }

    public function getAllComandas()
    {

        $comandas = $this->getComandas();


        return $comandas;
    }

    private function getComandas()
    {

        $selectComandas = "SELECT * FROM COMANDA";

        $resultComandas = $this->conn->query($selectComandas);

        $comandas = [];

        if ($resultComandas->num_rows > 0) {
            while ($row = $resultComandas->fetch_assoc()) {

                $comanda = new stdClass();

                $comanda->id_Comanda = intval($row["id_Comanda"]);
                $comanda->preuTotal = $row["preu_Total"];
                $comanda->dataComanda = $row["data_Comanda"];
                $comanda->nomUser = $row["nom_client"];
                $comanda->telefonUser = $row["telefon_client"];
                $comanda->emailUser = $row["correu_client"];
                $comanda->comandaFeta = $row["comanda_Feta"];
                $comanda->comentari = $row["comentario_pedido"];
                $comanda->lineasComanda = $this->getAllLineasComanda($comanda);

                $comandas[] = $comanda;
            }
        }

        return $comandas;
    }

    private function getAllLineasComanda($comanda)
    {

        $lineasComanda = [];

        $selectLineasComanda = "SELECT * FROM LINEA_COMANDA WHERE id_Comanda = " . $comanda->id_Comanda;

        $resultLineasComanda = $this->conn->query($selectLineasComanda);

        if ($resultLineasComanda->num_rows > 0) {
            while ($row = $resultLineasComanda->fetch_assoc()) {

                $lineaComanda = new stdClass();

                $lineaComanda->id_Producto = intval($row["id_Producto"]);
                $lineaComanda->preuProductoMoment = $row["preu_prod_mom"];
                $lineaComanda->cantitat = intval($row["cantidad"]);
                $lineaComanda->nomProducto = $this->getNomProducte($lineaComanda);

                $lineasComanda[] = $lineaComanda;
            }
        }

        return $lineasComanda;
    }

    private function getNomProducte($lineaComanda)
    {


        $selectNomProducto = "SELECT * FROM PRODUCTO WHERE id_Producto = " . $lineaComanda->id_Producto;

        $resultNomProducto = $this->conn->query($selectNomProducto);

        if ($resultNomProducto->num_rows > 0) {

            $row = $resultNomProducto->fetch_assoc();

            $nomProducto = $row["nom"];

            return $nomProducto;
        }
    }

    public function updateFet($id, $fet)
    {

        $updateComandaFeta = "UPDATE COMANDA SET comanda_Feta = " . $fet . " WHERE id_Comanda = " . $id;

        if ($this->conn->query($updateComandaFeta) === TRUE) {
            var_dump("exito");
        }

        $sql = "SELECT * FROM COMANDA WHERE id_Comanda = $id";

        $resultat = $this->conn->query($sql);
        $user = new stdClass();
        if ($resultat->num_rows > 0) {

            $row = $resultat->fetch_assoc();



            $user->correuClient = $row["correu_client"];
            $user->nomClient = $row["nom_client"];
        }

        return $user;
    }

    public function updateDades($producto, $campo, $dato) {

        if($campo == "descripcion"){
            $updateDades = "UPDATE PRODUCTO SET $campo = '$dato' WHERE nom ='$producto'";
        }
        else {
            $datoFloat = floatval($dato);
            $updateDades = "UPDATE PRODUCTO SET $campo = $datoFloat WHERE nom = '$producto'";
        }

        if ($this->conn->query($updateDades) === TRUE) {
            var_dump("exito");
        }

    }

    public function updateActivo($id, $fet) {

        $updateProductoActivo = "UPDATE PRODUCTO SET activat = " . $fet . " WHERE id_Producto = " . $id;

        if ($this->conn->query($updateProductoActivo) === TRUE) {
            var_dump("exito");
        }
    }
}
