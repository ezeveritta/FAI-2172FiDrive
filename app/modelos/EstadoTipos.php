<?php 
/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha: 23/10/2020
 */

include_once('Usuario.php');

class EstadoTipos
{
    // Instancias de bd
    private $id;              // int(11) PRIMARY KEY
    private $descripcion;     // varchar(100)
    private $activo;          // tinyint(1)
    // Extras
    private $error;

    public function __construct()
    {
        $this->id = "";
        $this->descripcion = "";
        $this->activo = "";
        $this->error = null;
    }

    /**
     * Esta función es para cargar al objeto de información
     * @param string $descripcion, $activo === Datos instancias de la BD
     */
    public function cargar($descripcion, $activo)
    {
        $this->set_descripcion($descripcion);
        $this->set_activo($activo);
    }

     /**
     * Función para buscar datos desde la base de datos según un id dado
     * @param int $id
     * 
     * @return boolean
     */
    public function buscar($id)
    {
        $bd = new BaseDatos();
		$query = "SELECT * from estadotipos  where idestadotipos =" . $id;
        $output = false;
        
        // Inicio conexión con bd
        if($bd->Iniciar())
        {
            // Ejecuto la consulta
            if($bd->Ejecutar($query))
            {
                // Recupero la información
                if($row2 = $bd->Registro())
                {
				    $this->set_id($id);
					$this->set_descripcion($row2['etdescripcion']);
                    $this->set_activo($row2['etactivo']);
					$output= true;
				}				
			
            } else
            {
		 		$this->set_error($bd->getError());
			}
        } else
        {
		 	$this->set_error($bd->getError());
		}
		return $output;
    }

    /**
     * Retornar toda la información de la base de datos
     * @param string $where
     * @param string $order
     * @return array
     */
    public static function listar($where = "", $order = "idestadotipos")
    {
	    $listaEstadoTipos = null;
        $query = "Select * from estadotipos";
        
		if ($where != "")
            $query = $query . ' where ' . $where;
        
        $query .= " order by " . $order;
        
        // Iniciamos conexión con bd
		$bd = new BaseDatos();
        if($bd->Iniciar())
        {
            // Ejecutamos la consulta
            if($bd->Ejecutar($query))
            {				
				$listaEstadoTipos = array();
                while($row2 = $bd->Registro())
                {
				    $id = $row2['idestadotipos'];
					$descripcion = $row2['etdescripcion'];
					$activo = $row2['etactivo'];
                
                    // Creamos el nuevo objeto Usuario con los datos obtenidos
                    $tmpEstadoTipo = new EstadoTipos();
                    $tmpEstadoTipo->set_id($id);
                    $tmpEstadoTipo->cargar($descripcion,$activo);
                    // Agregamos al arreglo
					array_push($listaEstadoTipos, $tmpEstadoTipo);
				}
            } else
            {
		 		$listaEstadoTipos = $bd->getError();
			}
        } else
        {
            $listaEstadoTipos = $bd->getError();
        }

		return $listaEstadoTipos;
	}	


    /**
     * Funcion para insertar los datos del objeto a la base de datos
     * @return boolean
     */
    public function insertar()
    {
		$bd     = new BaseDatos();
		$output = false;
		$query  = "INSERT INTO estadotipos(etdescripcion, etactivo)
                   VALUES ('".$this->get_descripcion()."',".$this->get_activo().")";
                   
        // Iniciamos conexión
        if($bd->Iniciar())
        {
            // Ejecutamos consulta
            if($id = $bd->Ejecutar($query))
            {
                $this->set_id($id);
			    $output = true;
            } else
            {
				$this->set_error($bd->getError());
			}

        } else
        {
			$this->set_error($bd->getError());
        }
        
		return $output;
    }

    /**
     * Esta función modifica los datos de la bd según las variables instancias
     * @return boolean
     */
    public function modificar(){
	    $output = false; 
	    $bd = new BaseDatos();
		$query = "UPDATE estadotipos SET etdescripcion='".$this->get_descripcion()
               ."',etactivo=". $this->get_activo()
               ." WHERE idestadotipos=".$this->get_id();
               
        // Iniciamos conexión
        if($bd->Iniciar())
        {
            // Ejecutamos consulta
            if($bd->Ejecutar($query))
            {
			    $output = true;
            } else
            {
				$this->set_error($bd->getError());
			}
        } else
        {
			$this->set_error($bd->getError());
        }
        
		return $output;
    }
    
    /**
     * Con ésta función eliminamos una tupla según la id.
     * @return boolean
     */
    public function eliminar(){
		$bd = new BaseDatos();
        $output = false;
        
        // Iniciamos conexión
        if($bd->Iniciar())
        {
            $query = "DELETE FROM estadotipos WHERE idestadotipos=".$this->get_id();

            // Ejecutamos consulta
            if($bd->Ejecutar($query))
            {
                $output = true;
            } else
            {
                $this->set_error($bd->getError());
            }
        } else
        {
			$this->set_error($bd->getError());
        }
        
		return $output; 
	}


    /**
     * Metodos de Acceso
     */
    public function get_id() { return $this->id; }
    public function get_descripcion() { return $this->descripcion; }
    public function get_activo() { return $this->activo; }
    public function get_error() { return $this->error; }
    
    public function set_id($data) { $this->id = $data; }
    public function set_descripcion($data) { $this->descripcion = $data; }
    public function set_activo($data) { $this->activo = $data; }
    public function set_error($data) { $this->error = $data; }

    public function __toString()
    {
        return "<b>Objeto EstadoTipos: </b>"
             . "<br>id: " . $this->get_id()
             . "<br>descipción: " . $this->get_descripcion()
             . "<br>activo: " . $this->get_activo();
    }
}