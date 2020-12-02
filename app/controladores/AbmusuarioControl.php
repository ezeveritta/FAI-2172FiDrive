<?php


////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
///// PHP - login
///// File: /app/vistas/login.php
///// Date: 02/12/2020 - 16:26
///// Description:
////////// Control para la vista abmusuario.
////////// 
////////////////////////////////////////////////////////////////////////////////////////////////////

class AbmusuarioControl
{
    private $error;

    public function __construct()
    {
        $this->error = '';
    }

    /**
     * Esta función retorna la información obtenida de las tablas "usuario" y "usaurioRol"
     * @return mixed boolean|array 
     */
    public static function get_info()
    {
        // Modelos a usar
        $Usuario = new Usuario();
        $UsuarioRol = new UsuarioRol();

        // Arreglo base a retornar
        $arreglo_retorno = array();

        // Consulto en la base de datos
        $arreglo_Usuarios = Usuario::listar();
        if ($arreglo_Usuarios === false)
        {
            return false;
        }
        
        // por cada registro, agrego al retorno junto a su roles
        foreach ($arreglo_Usuarios as $key => $usuario)
        {
            $arreglo_UsuarioRol = UsuarioRol::listar("idusuario = {$usuario->get_id()}");
            $rol_admin = $rol_usuario = $rol_otro = false;

            // obtengo los roles
            foreach ($arreglo_UsuarioRol as $UsuarioRol)
            {
                if ($UsuarioRol->get_rol()->get_id() == 1)
                    $rol_admin = true;
                if ($UsuarioRol->get_rol()->get_id() == 2)
                    $rol_usuario = true;
                if ($UsuarioRol->get_rol()->get_id() == 3)
                    $rol_otro = true;
            }

            $tmp_arreglo = [
                "id" => $usuario->get_id(),
                "nombre" => $usuario->get_nombre(),
                "apellido" => $usuario->get_apellido(),
                "login" => $usuario->get_login(),
                "activo" => $usuario->get_activo(),
                "rol_admin" => $rol_admin,
                "rol_usuario" => $rol_usuario,
                "rol_otro" => $rol_otro
            ];

            array_push($arreglo_retorno, $tmp_arreglo);
        }

        return $arreglo_retorno;
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
