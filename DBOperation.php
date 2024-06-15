<?php
class DBOperation
{
    private $con;

    // Constructor de donde sacamos las credenciales de la Base de Datos del archivo conexion.php
    function __construct()
    {
        require_once dirname(__FILE__) . '/conexion.php';
        $db = new DBconnect();
        $this->con = $db->connect();
    }

    // Funcion que nos permite insertar un usuario, en este caso no la ocuparemos
    public function insertUser($idtipo_usuario, $nombre, $email, $password, $apiKey)
    {
        $stmt = $this->con->prepare("INSERT INTO usuarios(idtipo_usuario, nombre, email, Password, apiKey) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $idtipo_usuario, $nombre, $email, $password, $apiKey);
        if ($stmt->execute())
            return true;
        return false;
    }

    // Funcion que nos permite realizar el login
    public function loginUser($email, $password) {
        // Toma dos parametros $password y $email, tambien realiza una consulta y se utiliza 'prepare' para evitar inyecciones SQL
        $stmt = $this->con->prepare("SELECT password FROM usuario WHERE email = ?");
        // verifica si la consulta fue exitosa
        if ($stmt) {
            $stmt->bind_param("s", $email); // vincula el parametro email a la consulta y le indica que es un string "s"
            $stmt->execute(); // ejecuta la consulta
            $stmt->store_result(); // almacena el resultado en el objeto $stmt
            if ($stmt->num_rows > 0) { // verifica si le llego algun resultado
                $stmt->bind_result($storedPassword); // vincula $storedPassword al resultado de la consulta, para almacenar la contraseña recuperada
                $stmt->fetch(); // obtiene el resultado y lo almacena en la variable
                // Verificar si la contraseña proporcionada coincide con la contraseña almacenada
                if ($password === $storedPassword) { // si coincide esta todo correcto
                    $response['error'] = false;
                    $response['message'] = 'Login successful';
                } else { // si falla, quiere decir que la contraseña esta mala
                    $response['error'] = true;
                    $response['message'] = 'Invalid password';
                }
            } else { // tambien puede fallar el correo
                $response['error'] = true;
                $response['message'] = 'Email not found';
            }
        } else {
            $response['error'] = true;
            $response['message'] = 'Error preparing statement';
        }
        $stmt->close(); // cierra la consulta
        return $response; // devuelve la respuesta
    }
    
    // Funcion que nos permite obtener los usuarios registrados
    public function getUser()
    {
        $stmt = $this->con->prepare("SELECT idusuario, idtipo_usuario, nombre, email FROM usuario");
        $stmt->execute();
        $stmt->bind_result($idusuario, $idtipo_usuario, $nombre, $email);
        $usuarios = array();

        while ($stmt->fetch()) {
            $temp = array();
            $temp['idusuario'] = $idusuario;
            $temp['idtipo_usuario'] = $idtipo_usuario;
            $temp['nombre'] = $nombre;
            $temp['email'] = $email;
            array_push($usuarios, $temp);
        }
        return $usuarios;
    }

    // Funcion que nos permite obtener los registros que debemos obtener del servidor
    public function getRegister()
    {
        $stmt = $this->con->prepare("SELECT idregistro, idestado_registro, idtipo_registro, registro, fecha FROM registro");
        $stmt->execute();
        $stmt->bind_result($idregistro, $idestado_registro, $idtipo_registro, $registro, $fecha);
        $registros = array();

        while ($stmt->fetch()) {
            $temp = array();
            $temp['idregistro'] = $idregistro;
            $temp['idestado_registro'] = $idestado_registro;
            $temp['idtipo_registro'] = $idtipo_registro;
            $temp['registro'] = $registro;
            $temp['fecha'] = $fecha;
            array_push($registros, $temp);
        }
        return $registros;
    }
}
?>
