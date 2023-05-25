<?php 
//Controlador de php para insertar datos nuevos a la bd,
//haciendo uso del método de la clase de php Connection:
include 'ClassConnection.php';
$connection = new Connection();
//Verifico que el método que se pasa es POST
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $gender = $_POST['gender'];
    $nameUser = $_POST['nameUser'];
    $lastname = $_POST['lastname'];
    $city = $_POST['city'];
    
    $query = "INSERT INTO userData (gender, nameUser, lastname, city) VALUES ('$gender', '$nameUser', '$lastname', '$city')";
    $result = $connection->consult($query);

}

?>