<?php

/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha : 03-11-2020 11:19
 * Descripción:
 */

class UsuarioRol
{
    private $id;
    private $Usuario;   // Obj Usuario
    private $Rol;       // Obj Rol
    private $error;

    public function __construct()
    {
        $this->id = array('idUsuario' => '', 'idRol' => '');
        $this->Usuario = new Usuario();
        $this->Rol     = new Rol();
        $this->error   = '';
    }

    /**
     * Ésta función carga datos a las variables instancias del objeto.
     * @param string     $idUsuario          : id del Usuario
     * @param string     $idRol              : id del Rol
     */
    public function cargar(string $idUsuario, string $idRol)
    {
        $this->set_id($idUsuario, $idRol);
        $this->set_usuario($idUsuario);
        $this->set_rol($idRol);
    }

    /**
     * Ésta función busca en la BD un registro y carga los datos en el objeto.
     * @param string $idUsuario   : Identificador para encontrar registros de un usuario
     * @param string $idRol       : Identificador para encontrar registros de un rol
     * @return boolean
     */
    public function buscar(string $idUsuario, string $idRol)
    {
        $conexion = new BaseDatos();
        $consulta = "SELECT * FROM usuariorol WHERE idusuario = $idUsuario AND idrol = $idRol";

        // Inicio conexión con la BD
        if (!$conexion->Iniciar()) {
            $this->set_error($conexion->getError() );
            return false;
        }

        // Ejecuto la consulta
        if (!$conexion->Ejecutar($consulta)) {
            $this->set_error($conexion->getError());
            return false;
        }

        // Recupero la información
        if ($row2 = $conexion->Registro()) {
            $this->cargar($row2['idusuario'], $row2['idrol']);
        }
        return true;
    }

    /**
     * Ésta función retorna un arreglo con los registros encontrados de la tabla usuariorol.
     * @param string $where     : Permite agregar condiciones.
     * @param string $limite    : Permite limitar la cantidad de registros a obtener.
     * @param string $orden     : Valor para ordenar los registros.
     * @return mixed array|boolean|string
     */
    public static function listar(string $where ="", string $limite ="", string $orden = "idusuario")
    {
        $arregloUsuarioRol = null;
        $conexion = new BaseDatos();
        $consulta = "SELECT * FROM usuariorol";

        if ($where != "")
            $consulta .= " WHERE $where";
        if ($limite != "")
            $consulta .= " LIMIT $limite";

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
        $arregloUsuarioRol = array();
        while ($row2 = $conexion->Registro()) 
        {
            $idUsuario       = $row2['idusuario'];
            $idRol           = $row2['idrol'];

            // Creamos el nuevo objeto UsuarioRol con los datos obtenidos
            $tmp_usuarioRol = new UsuarioRol();
            $tmp_usuarioRol->cargar($idUsuario, $idRol);
            // Agregamos al arreglo
            array_push($arregloUsuarioRol, $tmp_usuarioRol);
        }

        return $arregloUsuarioRol;
    }

    /**
     * Éste método inserta un registro en la tabla usuariorol.
     * @return boolean
     */
    public function insertar()
    {
        $conexion     = new BaseDatos();
        $consulta  = "INSERT INTO usuariorol(idusuario, idrol) 
				   VALUES ('{$this->get_usuario()->get_id()}', '{$this->get_rol()->get_id()}')";

        // Iniciamos conexión
        if (!$conexion->Iniciar()) {
            $this->set_error( $conexion->getError() );
            return false;
        }
        // Ejecutamos consulta
        if ($conexion->Ejecutar($consulta)) {
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
        $id        = $this->get_id();
        $idUsuario = $this->get_usuario()->get_id();
        $idRol     = $this->get_rol()->get_id();

        $conexion = new BaseDatos();
        $consulta = "UPDATE usuariorol 
                     SET idusuario = $idUsuario, 
                         idrol = $idRol
                     WHERE idusuario = {$id['idUsuario']}
                     AND   idrol = {$id['idRol']}";

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
     * Con ésta función eliminamos un registro según la variable idusuario.
     * @return boolean
     */
    public function eliminar()
    {
        $idUsuario = $this->get_usuario()->get_id();
        $idRol     = $this->get_rol()->get_id();

        $conexion = new BaseDatos();

        // Iniciamos conexión
        if (!$conexion->Iniciar()) {
            $this->set_error( $conexion->getError() );
            return false;
        }

        $query = "DELETE FROM usuariorol WHERE idusuario = $idUsuario and idrol = $idRol";

        // Ejecutamos consulta
        if (!$conexion->Ejecutar($query)) {
            $this->set_error($conexion->getError());
            return false;
        }

        return true;
    }

    // Métodos de acceso
    public function get_id() { return $this->id; }
    public function get_usuario() { return $this->Usuario; }
    public function get_rol() { return $this->Rol; }
    public function get_error() { return $this->error; }

    public function set_id($idUsuario, $idRol) { $this->id['idUsuario'] = $idUsuario; $this->id['idRol'] = $idRol; }
    public function set_usuario($data) { $this->Usuario->buscar($data); }
    public function set_rol($data) { $this->Rol->buscar($data); }
    public function set_error($data) { $this->error = $data; }

    public function __toString()
    {
        return "<br><b><u> Objeto UsuarioRol</b></u>: 
                <br><b> Usuario</b>: {$this->get_usuario()}
                <br><b> Rol</b>: {$this->get_rol()}
                <br><b> error</b>: {$this->get_error()}";
    }
}