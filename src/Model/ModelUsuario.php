<?php
class ModelUsuario extends BaseModel
{
	protected static $lista_info = [	
		"id_usuario", 		"email", 		"dni",
		"nombre", 			"apellido_1",	"apellido_2", 
		"direccion",		"imagen_perfil","nombre_usuario", 
		"fecha_nacimiento",	"sexo", 		"nacionalidad",
		"id_tipo_usuario", 	"fecha_alta",
						]; // Pendiente comentarios.

    protected static $campo_id = "id_usuario";
    protected static $tabla = "usuario";
   /* static $basicData = [	
    	"id_usuario", 		"email", 		"dni", 
		"nombre", 			"apellido_1",	"apellido_2", 
		"direccion",		"imagen_perfil","nombre_usuario", 
		"fecha_nacimiento",	"sexo", 		"nacionalidad",
		"id_tipo_usuario", 	"fecha_alta",
						]; // Pendiente comentarios.
*/
	public static function logIn(string $user, string $pass){
		return static::autentificar($user, $pass);
	}


	public static function logOut(string $token){
		
	}


	public function autentificar(string $user, string $pass){
		$usuario = ModelUsuario::existeUsuario($user);
		if ($usuario) {
			$auxPass = $usuario[0]['contrasena'];
			if (password_verify($pass,$auxPass)) {
				return $usuario[0];
			}else{
				return false;
			}
		}
	}

	static function getById($id){
		$db = App::getDB();
		$SQL = "select * from usuario where nombre_usuario = ? or email = ?;";
		$usuario = $db->ejecutar($SQL, $user, $user);
		return $usuario;
	}

	static function getBasicDataJSON($id){
		$db = App::getDB();
		$camposBasicData = implode(",", static::$lista_info);
		$SQL = "select $camposBasicData from usuario where ".static::$campo_id." = ?;";
		$usuario = $db->ejecutar($SQL, $id);
		if ($usuario) {
			$usuario = json_encode($usuario[0]);
		}
		return $usuario;	
	}

	static function clasesDeUsuario($id){
		$db = App::getDB();
		$SQL = "select nombre_clase from asiste a, clase c where a.id_usuario = ? and a.id_clase = c.id_clase;";
		$auxClases = $db->ejecutar($SQL, $id);
			$clases = [];
		if (count($auxClases) > 0) {
			foreach ($auxClases as $key => $value) {
                array_push($clases, $value['nombre_clase']);
            }
            $clases = implode(', ', $clases);
		}else{
			$clases = "Aun no estas en ninguna de nuestras clases. ";
		}
		return $clases;
	}

	static function getGustos($id){
		$db = App::getDB();
		$SQL = "select * from gustos_usuario where id_usuario = ?;";
		
		$gustos = $db->ejecutar($SQL, $id);
		
		if (!empty($gustos)) {
			return $gustos[0];
		}else{
			return ["deportes_favoritos" => "Aun no has definido tus deportes favoritos.",
					"comentarios" => "Aun no has hecho ningún comentario."];
		}
		
	}


	public static function existeUsuario(string $user){
		$db = App::getDB();
		$SQL = "select * from usuario where nombre_usuario = ? or email = ?;";
		$usuario = $db->ejecutar($SQL, $user, $user);
		return $usuario;
	}


	public function getLocalizacion(){}

	public static function getDatosClases()
	{
		$db = App::getDB();
		$query = "SELECT nombre_clase,
						 fecha,
        				 hora_inicio,
        				 hora_fin,
        				 precio_clase
        				 FROM clase;";
		
		$resultado = $db->ejecutar($query);
		return $resultado;
	}


	static function calcularEdad($nacimiento){
		$cumpleanos = new DateTime($nacimiento);
	    $hoy = new DateTime();
	    $anios = $hoy->diff($cumpleanos);
	    return $anios->y;
	}

	public static function registrar()
	{
		$db = App::getDB();
		$_POST["contrasena"] = password_hash($_POST["contrasena"],2);
		$campos_para_insert = implode(",",ModelRegistroForm::getListaDatos());
	
		$parametros_para_insert = implode(",",array_fill(0,(count(ModelRegistroForm::getListaDatos())), "?"));
		
		$sql_insert = "INSERT INTO usuario ($campos_para_insert) VALUES ($parametros_para_insert);";
            
            // print_r(array_values(array_slice($this->data,1)));
			$resultado = $db->ejecutar($sql_insert, ...array_values($_POST));
            if (is_array($resultado)) {
				return true;
            }
		
	}//registrar
        
        public static function todosDeporte(){
            
            $db = App::getDB();
		$query = "SELECT * FROM deporte;";
		
		$resultado = $db->ejecutar($query);
		return $resultado;
        }

}
?>