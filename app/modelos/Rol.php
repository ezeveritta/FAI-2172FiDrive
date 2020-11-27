<?php

/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha : 03-11-2020 12:42
 * Descripción:
 */

class Rol
{
    private $id;
    private $descripcion;
    private $error;

    public function __construct()
    {
        $this->id = '';
        $this->descripcion = '';
        $this->error = '';
    }

    /**
     * Ésta función carga datos a las variables instancias del objeto.
     * @param string     $descripcion     : descripcion del rol
     */
    public function cargar(string $descripcion)
    {
        $this->set_descripcion($descripcion);
    }

    /**
     * Ésta función busca en la BD un registro y carga los datos en el objeto.
     * @param string $valor     : Identificador para encontrar el registro.
     * @param string $where     : Cambia el parámetro del 'where' en el sql.
     * @return boolean
     */
    public function buscar(string $valor, string $where = 'idrol')
    {
        $conexion = new BaseDatos();
        $consulta = "SELECT * FROM rol WHERE $where = $valor";

        // Inicio conexión con la BD
        if (!$conexion->Iniciar()) {
            $this->set_error( $conexion->getError() );
            return false;
        }

        // Ejecuto la consulta
        if (!$conexion->Ejecutar($consulta)) {
            $this->set_error($conexion->getError());
            return false;
        }

        // Recupero la información
        if ($row2 = $conexion->Registro()) {
            $this->set_id($row2['idrol']);
            $this->cargar($row2['rodescripcion']);
        }
        return true;
    }

    /**
     * Ésta función retorna un arreglo con los registros encontrados de la tabla rol.
     * @param string $where     : Permite agregar condiciones.
     * @param string $limite    : Permite limitar la cantidad de registros a obtener.
     * @param string $orden     : Valor para ordenar los registros.
     * @return mixed array|boolean|string
     */
    public static function listar(string $where ="", string $limite ="", string $orden = "idrol")
    {
        $arregloRol = null;
        $conexion = new BaseDatos();
        $consulta = "SELECT * FROM rol";

        if ($where != "")
            $consulta .= " WHERE = $where";
        if ($limite != "")
            $consulta .= " LIMIT = $limite";

        $consulta .= " ORDER BY $orden";

        // Iniciamos conexión con BD.
        if (!$conexion->Iniciar()) {
            return $conexion->getError();
        }

        // Ejecutamos la consulta.
        if (!$conexion->Ejecutar($consulta)) {
            return $conexion->getError();
        }

        // Retornamos la información obtenida.
        $arregloRol = array();
        while ($row2 = $conexion->Registro()) 
        {
            $id            = $row2['idrol'];
            $descripcion   = $row2['rodescripcion'];

            // Creamos el nuevo objeto Rol con los datos obtenidos
            $tmp_rol = new Rol();
            $tmp_rol->set_id($id);
            $tmp_rol->cargar($descripcion);
            // Agregamos al arreglo
            array_push($arregloRol, $tmp_rol);
        }

        return $arregloRol;
    }

    /**
     * Éste método inserta un registro en la tabla rol.
     * @return boolean
     */
    public function insertar()
    {
        $conexion     = new BaseDatos();
        $consulta  = "INSERT INTO rol(rodescripcion) VALUES ('{$this->get_descripcion()}')";

        // Iniciamos conexión
        if (!$conexion->Iniciar()) {
            $this->set_error( $conexion->getError() );
            return false;
        }
        // Ejecutamos consulta
        if ($id = $conexion->Ejecutar($consulta)) {
            $this->set_id($id);
            $output = true;
        } else {
            $this->set_error( $conexion->getError() );
            $output = false;
        }

        return $output;
    }


    /**
     * Esta función modifica los datos de la BD según las variables instancias
     * @return boolean
     */
    public function modificar()
    {
        $conexion = new BaseDatos();
        $consulta = "UPDATE rol SET rodescripcion = '{$this->get_descripcion()}' WHERE idrol = {$this->get_id()}";

        // Iniciamos conexión
        if (!$conexion->Iniciar()) {
            $this->set_error( $conexion->getError() );
            return false;
        }

        // Ejecutamos consulta
        if (!$conexion->Ejecutar($consulta)) {
            $this->set_error($conexion->getError());
            return false;
        }

        return true;
    }

    /**
     * Con ésta función eliminamos un registro según la variable idrol.
     * @return boolean
     */
    public function eliminar()
    {
        $conexion = new BaseDatos();

        // Iniciamos conexión
        if (!$conexion->Iniciar()) {
            $this->set_error( $conexion->getError() );
            return false;
        }

        $query = "DELETE FROM rol WHERE idrol = {$this->get_id()}";

        // Ejecutamos consulta
        if (!$conexion->Ejecutar($query)) {
            $this->set_error($conexion->getError());
            return false;
        }

        return true;
    }

    // Métodos de acceso
    public function get_id() { return $this->id; }
    public function get_descripcion() { return $this->descripcion; }
    public function get_error() { return $this->error; }

    public function set_id($data) { $this->id = $data; }
    public function set_descripcion($data) { $this->descripcion = $data; }
    public function set_error($data) { $this->error = $data; }

    public function __toString()
    {
        return "<br><b> Objeto Rol</b>: 
                <br><b> id</b>: {$this->get_id()}
                <br><b> Descripcion</b>: {$this->get_descripcion()}
                <br><b> Error</b>: {$this->get_error()}";
    }
}