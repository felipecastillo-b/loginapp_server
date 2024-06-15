<?php
    class DBconnect 
    {
        // Variable para almacenar el enlace de la base de datos
        private $con;

        // Clase constructor
        function __construct()
        {

        }

        // Método que se conectará a la base de datos
        function connect() 
        {
            // Incluye el archivo constants.php para obtener las credenciales de la base de datos
            include_once dirname(__FILE__) . '/Constants.php';

            // Conexión a la base de datos de phpMyAdmin
            $this->con = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

            // Comprueba si hubo algún error durante la conexión
            if($this->con->connect_errno) {
                echo "Failed to connect to phpMyAdmin: " . $this->con->connect_error;
                return null;
            }

            return $this->con;
        }
    }
?>
