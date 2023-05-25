<?php 
//Controlador de php para obtener todos los datos de la 
//tabla userData, haciendo uso del método consult de la clase
//Connection
include 'ClassConnection.php';
$connection = new Connection();
//Verifico que el método que se pasa es GET
if($_SERVER["REQUEST_METHOD"] == "GET"){
    $query = "SELECT * FROM userData";
    $result = $connection->consult($query);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            $response[] = $row;
        }
    }else {
        echo "No hay información que mostrar aún";
    }
    
    echo json_encode($response);
}


?>
