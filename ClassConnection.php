
<?php
include("connection_env.php");
class Connection
{
    private $connection;
    private $consult;
    public function __construct()
    {   
        //Establezco la conexión con la base de datos a
        //a través del método mysqli();
        if (!isset($this->connection)) {
            $this->connection = new mysqli(SERVER, USER, PASSWORD, DB_NAME) or die('Connection failed' . $this->connection->connect_error);
        }
    
    }
    //Creo los métodos necesarios para hacer query's a la BD:
    public function consult($consult){
        $this->consult = $this->connection->query($consult);
        if(!$this->consult){
            echo 'MySql Error: ' .$this->connection->error;
            echo $consult;
            exit;
        }
        return $this->consult;
    }
    public function num_rows(){
        return $this->consult->num_rows;
    }
    public function results(){
        $rows = array();
        while($row = mysqli_fetch_array($this->consult)){
            $rows[] = $row;
        }
        return $rows;
    }
    public function delete($table_name, $idToDelete){
        $consult = "DELETE FROM $table_name WHERE id = $idToDelete";
        $this->consult = $this->connection->query($consult);
        if(!$this->consult){
            echo 'MySql Error: ' .$this->connection->error;
            echo $consult;
            exit;
        }
    }
}


?>