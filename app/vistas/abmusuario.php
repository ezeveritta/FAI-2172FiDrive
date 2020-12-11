<?php
# Configuración de la página
include_once("../../configuracion.php");
include_once("../../utiles/session.php");
$datos = data_submitted();

# Cargo clases a utilizar
include_once("../controladores/AbmusuarioControl.php");

////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
///// PHP - abmusuario
///// File: /app/vistas/abmusuario.php
///// Date: 02/12/2020 - 16:11
///// Description:
////////// Vista donde el usuario con permiso de 'administrador' puede dar de alta, baja o
////////// modificación a los demás usuarios..
////////////////////////////////////////////////////////////////////////////////////////////////////
// Verifico acceso a la vista //////////////////////////////////////////////////////////////////////
if (!$logueado)
{
    header('Location: login.php');
    die();
}

# Verifico si hay una sesión logeada
if (!$esAdmin)
{
    header('Location: compartidos.php?aviso=No+tienes+permiso.');
    die();
}

# obtengo info de los usuarios
$arreglo_Usuarios = AbmusuarioControl::get_info();

# Configuración de la vista
$CONFIG["titulo"] = "ABM Usuario - FAI-2172";

# Inicio HTML
include_once("estructura/cabecera.php");
echo get_aviso($datos); 
?>

        <!-- Contenido -->
        <div class="col-md-10 col-xs-12">
            <div class="row h-100">
                <div class="col-sm-12 my-3">
                    <?php if (($arreglo_Usuarios) == false) {
                        echo "<h2>Error al consultar la base de datos.</h2>";
                    } else { ?>
                    <table class="table table-sm table-striped border">

                        <thead>
                            <tr>
                                <th scope="col">id</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Apellido</th>
                                <th scope="col">Login</th>
                                <th scope="col">Activo</th>
                                <th scope="col">Editar</th>
                                <th scope="col">Rol</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php

                            foreach ($arreglo_Usuarios as $usuario)
                            {
                                
                                $rol_admin   = ($usuario["rol_admin"]) ? 'checked="enabled"' : '';
                                $rol_usuario = ($usuario["rol_usuario"]) ? 'checked="enabled"' : '';
                                $rol_otro    = ($usuario["rol_otro"]) ? 'checked="enabled"' : '';
                                echo "<tr>
                                        <th scope=\"row\">{$usuario["id"]}</th>
                                        <td>{$usuario["nombre"]}</td>
                                        <td>{$usuario["apellido"]}</td>
                                        <td>{$usuario["login"]}</td>
                                        <td>{$usuario["activo"]}</td>
                                        <td><a href=\"#\">editar</a></td>
                                        <td>
                                            <label><input type=\"checkbox\" class=\"editar_rol_admin\" $rol_admin> Administrador </label>
                                            <label><input type=\"checkbox\" class=\"editar_rol_usuario\" $rol_usuario> Usuario </label>
                                            <label><input type=\"checkbox\" class=\"editar_rol_otro\" $rol_otro> Otro </label>
                                        </td>
                                    </tr>";
                            }
                            ?>

                        </tbody>
                    </table>
                    <?php }?>
                    
                </div>
            </div>
        </div>

    </div>
</div>

<?php
include_once("estructura/pie.php");
?>