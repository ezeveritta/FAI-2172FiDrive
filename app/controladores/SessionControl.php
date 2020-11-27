<?php

/**
 * Alumno: Ezequiel Vera
 * Legajo: FAI-2172
 * Fecha : 21:20
 * Descripción: Implementar dentro de la capa de Control la clase Session con los siguientes métodos:
 *                  ++• _ _construct(). Constructor que. Inicia la sesión.
 *                  ++• iniciar($nombreUsuario,$psw). Actualiza las variables de sesión con los valores ingresados.
 *                  ++• validar(). Valida si la sesión actual tiene usuario y psw válidos. Devuelve true o false.
 *                  ++• activa(). Devuelve true o false si la sesión está activa o no.
 *                  ++• getUsuario().Devuelve el usuario logeado.
 *                  ??• getRol(). Devuelve el rol del usuario logeado.
 *                  ++• cerrar(). Cierra la sesión actual.
 */

class SessionControl
{
    protected $idUsuario;
    private $error;

    public function __construct()
    {
        if (!isset($_SESSION))
        {
            $this->iniciar_session();
        }
    }


    /**
     * Éste método verifica si el usuario tiene permisos de administrador
     * @return boolean
     */
    public function esAdministrador()
    {
        // Obtengo los roles del usuario
        $roles = $this->get_rol();
        
        return (in_array('admin', $roles));
    }

    /**
     * Cierra la sesión actual.
     */
    public static function cerrar()
    {
        if (SessionControl::activa() == 2)
        {
            $_SESSION = array();
            return session_destroy();
        }
        return false;
    }


    /**
     * Devuelve el rol del usuario logeado.
     * @return array
     */
    public function get_rol()
    {
        $idUsuario = $this->get_idUsuario();
        $arregloUsuarioRoles = UsuarioRol::listar("idusuario=$idUsuario");
        $arregloRoles = array();
        foreach($arregloUsuarioRoles as $usuarioRol)
        {
            array_push($arregloRoles, $usuarioRol->get_rol()->get_descripcion());
        }

        return $arregloRoles;
    }


    /**
     * Devuelve el usuario logeado
     * @return Usuario
     */
    public function get_usuario()
    {
        $objUsuario = new Usuario();
        $objUsuario->buscar($this->get_idUsuario());
        return $objUsuario;
    }

    /**
     * Devuelve true o false si la sesión está activa o no.
     * @return boolean
     */
    public static function activa()
    {
        return session_status();
    }

    /**
     * Ésta función valida si la sesión actual tiene usuario y psw válidos. Devuelve true o false.
     * @return boolean
     */
    public static function validar()
    {
        return isset($_SESSION['idUsuario']);
    }

    /**
     * Ésta función consulta si los datos corresponden a un usuario y setea los datos en $_SESSION.
     * @return boolean
     */
    public function entrar($usuario, $contraseña)
    {
        if (isset($_SESSION['idUsuario']))
            return false;
            
        if ($idUsuario = Usuario::validar_cuenta($usuario, $contraseña))
        {
            $this->set_idUsuario($idUsuario);
            return true;
        }

        return false;
    }

    /**
     * Ésta función inicia la variable global SESSION. sin valores.
     */
    private function iniciar_session()
    {
        session_start();
    }

    public function get_idUsuario() { return $_SESSION['idUsuario']; }
    public function get_error() { return $this->error; }

    public function set_idUsuario($data) { $_SESSION['idUsuario'] = $data; }
    public function set_error($data) { $this->error = $data; }

    public function __toString()
    {
        return "<br> Objeto Control: 
                <br> idUsuario: {$this->get_idUsuario()}
                <br> error: {$this->get_error()}";
    }
}