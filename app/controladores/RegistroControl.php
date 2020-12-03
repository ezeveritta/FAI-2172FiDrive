<?php


////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
///// PHP - RegistroControl
///// File: /app/controladores/RegistroControl.php
///// Date: 03/12/2020 - 15:14
///// Description:
////////// Control para la vista y acción 'registro'.
////////// 
////////////////////////////////////////////////////////////////////////////////////////////////////

class RegistroControl
{
    private $error;

    public function __construct()
    {
        $this->error = '';
    }

    /**
     * Esta función comprueba que los datos del formulario sean válidos para 
     * almacenar en la base de datos
     * @param array $datos      : Datos del servidor
     * 
     * @return boolean
     */
    public static function validar($datos)
    {
        # Validación simple
        if ( !isset($datos['usuario']) || !isset($datos['nombre']) || !isset($datos['apellido']) || !isset($datos['contraseña']))
        {
            $this->set_error("Datos faltantes.");
            return false;
        }

        return true;
    }

    /**
     * Esta función se conecta con la BD intentando reguistrar un usuario
     * @param array $datos      : Datos del servidor
     * 
     * @return mixed boolean|array 
     */
    public function registrar($datos)
    {
        # Inicio los modelos a utilzar
        $Usuario = new Usuario();
        $UsuarioRol = new UsuarioRol();

        # Defino sus parámetros
        $Usuario->cargar($datos['nombre'], $datos['apellido'], $datos['usuario'], $datos['contraseña'], "1");
        
        # Cargo Usuario en la BD
        if ( $idUsuario = $Usuario->insertar() === false )
        {
            $this->set_error("Error al cargar usuario en la base de datos.");
            return false;
        }

        # Cargo UsuarioRol con rol = usuario(2)
        $UsuarioRol->cargar($idUsuario, 2);

        # Inserto Rol
        if ( !$UsuarioRol->insertar() )
        {
            //$Usuario->eliminar();
            $this->set_error("Error al definir rol.");
            return false;
        }
        
        # Termino método
        return true;
    }



    /**
     * Métodos de acceso
     */
    public function set_error($data) { $this->error = $data; }
    public function set_archivoCargado($data) { $this->archivoCargado = $data; }
    public function set_archivoCargadoEstado($data) { $this->archivoCargadoEstado = $data; }
    public function get_error() { return $this->error; }
    public function get_archivoCargado() { return $this->archivoCargado; }
    public function get_archivoCargadoEstado() { return $this->archivoCargadoEstado; }
    public function __toString()
    {
        return  "Objeto AmarchivoControl:
                 <br> Error: $this->get_error()
                 <br> ArchivoCargado: $this->get_archivoCargado()
                 <br> ArchivoCargadoEstado: $this->get_archivoCargadoEstado()";
    }
}
