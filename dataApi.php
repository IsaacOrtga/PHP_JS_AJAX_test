<?php 
//Solicitud a la API randomuser.me, para recoger
//datos de usuarios aleatorios con la biblioteca cURL:

//Recogiendo la clase cURL de php
include 'ClassCurl.php';
//verifico el tipo de método que se va a pasar
if ($_SERVER["REQUEST_METHOD"] == "GET") {
//creo la nueva instancia llamada curlObject con la clase new Curl()
$curlObject = new Curl();
//Paso la url para hacer set en el setUrl, declarada en la clase
$curlObject->setUrl('https://randomuser.me/api/?results=5');
//realizo la consulta a través del método consult()
$curlObject->consult();
//cierro la consulta y luego guardaré todo en un json 
//que me devuelva los resultados para manejarlos
$curlObject->close();
$data_decode = json_decode($curlObject->getData(), true);
$results = $data_decode['results'];
$status = $curlObject->getStatus();
$statusCode = $status['http_code'];
//Control de errores, si no es 200 la petición ha salido mal
//y lanzo un error, si sale bien envío la información del status y 
//los datos del usuario:
if ($statusCode == '200') {

    echo json_encode([$statusCode, $results]);
}

}else{
    echo json_encode('ERROR');
}

?> 