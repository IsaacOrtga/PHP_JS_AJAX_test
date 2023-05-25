<?php 
//Controlador de php para borrar usuarios por id,
//haciendo uso del método delete() del controlador:
include 'ClassConnection.php';
$connection = new Connection();
//Verifico que el método que se pasa es POST
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $idToDelete = $_POST['id'];
    $table_name = 'userData';
    $connection->delete($table_name, $idToDelete);
    
    $response = [
        'success'=> true
    ];
    echo json_encode($response);
}


?>
