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
        // Prepara una consulta SQL donde obtendra las columnas idregistro, idestado_registro, idtipo_registro, registro y fecha de la tabla registro
        $stmt = $this->con->prepare("SELECT id, idCaja, sensor1, sensor2, sensor3, sensor4, sensor5, fechaHora FROM registro ORDER BY id DESC");
        $stmt->execute(); // ejecuta la consulta
        $stmt->bind_result($id, $idCaja, $sensor1, $sensor2, $sensor3, $sensor4, $sensor5, $fechaHora); // vincula las variables con los resultados de la consulta
        $registros = array(); // inicializa un arreglo vacio

        while ($stmt->fetch()) { // asigna los valores de las variables vinculadas al arreglo $temp
            $temp = array();
            $temp['id'] = $id;
            $temp['idCaja'] = $idCaja;
            $temp['sensor1'] = $sensor1;
            $temp['sensor2'] = $sensor2;
            $temp['sensor3'] = $sensor3;
            $temp['sensor4'] = $sensor4;
            $temp['sensor5'] = $sensor5;
            $temp['fecha'] = $fechaHora;
            array_push($registros, $temp); // añade el arreglo temporal $temp al arreglo $registros
        }
        return $registros; // retorna el arreglo $registros
    }
}
?>
