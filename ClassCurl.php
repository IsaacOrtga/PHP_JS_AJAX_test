<?php

class Curl
{
    //Declaro las variables al as que hacer set cuando las utilice
    //con un tipo privado para que no puedan ser manipuladas fuera
    //de la clase
    private $url = '';
    private $method = 'get';
    private $handler = null;
    private $data = '';
    private $status = '';
    function setUrl($url)
    {
        return $this->url = $url;
    }
    function getUrl()
    {
        return $this->url;
    }
    function getData()
    {
        return $this->data;
    }
    function setMethod($method)
    {
        return $this->method = $method;
    }
    function getMethod()
    {
        return $this->method;
    }
    function getStatus()
    {
        return $this->status;
    }
    //Construyo el método de consulta con métodos propios de cURL,
    //así como actualizo el valor de las variables privadas
    //cargando el método curl_init() que inicia la librería
    //o la variable data que ejecuta la búsqueda, entre otras:
    public function consult()
    {
        try {
            if ($this->handler == null) {
                $this->handler = curl_init();
            }
            if (strtolower($this->method === 'get')) {

                curl_setopt_array($this->handler, [
                    CURLOPT_URL => $this->url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_HTTPGET => true,
                    CURLOPT_HEADER => 0,
                    CURLOPT_POST => false
                ]);
            }
            $this->data = curl_exec($this->handler);

            $this->status = curl_getinfo($this->handler);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }
    //Vuelvo a darle un valor de null a handler, para que 
    //vuelva a su estado inicial al cerrar la petición.
    public function close()
    {
        curl_close($this->handler);
        $this->handler = null;
    }
}
