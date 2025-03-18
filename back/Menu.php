<?php
include_once("config.php");

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$selectProductos = "SELECT * FROM PRODUCTO";

$result = $conn->query($selectProductos);

$productos = [];

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {

    $producto = new stdClass();

    $producto->id = intval($row["id_Producto"]);
    $producto->nom = $row["nom"];
    $producto->precio = floatval($row["precio"]);
    $producto->descripcion = $row["descripcion"];
    $producto->horario = intval($row["horario"]);
    $producto->url_Imagen = $row["url_Imagen"];
  
    $productos[] = $producto;
  }
} else {
  echo "0 results";
}

$conn->close();

header('Content-Type: application/json; charset=utf-8');
echo json_encode(['productos' => $productos]);