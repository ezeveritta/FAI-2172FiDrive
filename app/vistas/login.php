<?php

# Configuración de la página
include_once("../../configuracion.php");
include_once("../../utiles/session.php");

# Verifico si hay una sesión logeada
if ($logueado)
{
    header('Location: compartidos.php');
    die();
}

////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////
///// PHP - login
///// File: /app/vistas/login.php
///// Date: 27/11/2020 - 15:02
///// Description:
////////// Vista donde el cliente accede cuando aún no inició sesión.
////////// 
////////////////////////////////////////////////////////////////////////////////////////////////////

# Configuración de la vista
$CONFIG["titulo"] = "Login - FAI-2172";
$CONFIG["cabecera"] = false;
$CONFIG["menu"] = false;
$CONFIG["pie"] = false;

# Inicio HTML
include_once("estructura/cabecera.php");

?>

        <!-- Contenido -->
        <div class="col-md-12 col-xs-12">
            <div class="h-100">
                <div class="">

                    <!-- Cabecera simple -->
                    <div class="d-block w-100 navbar navbar-light flex-md-nowrap p-3">
                        <div class="w-100 d-flex justify-content-center">
                            <div class="ml-5 pt-2">
                                <a href="login.php" class="text-dark text-SansiteSwashed">FiDrive</a>
                            </div>
                            <div class="mr-3 pt-2">
                                <a href="https://github.com/ezeveritta/FAI-2172FiDrive" class="d-inline-block text-dark ml-5 mr-3 text-SansiteSwashed">GitHub</a>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex p-5 w-100" id="contenedor">

                        <!-- Iniciar Session -->
                        <div class="login pt-4 pb-5 px-5 w-50" id="card_login">
                            <form action="accion/login.php" method="post" class="form w-50 float-left">
                                <h3>Iniciar Sesión</h3>
                                <div class="form-group mt-3">
                                    <h6><label class="" for="usuario">Nombre de usuario</label></h6>
                                    <input type="text" name="usuario" class="form-control" id="usuario">
                                    <div class="invalid-feedback"></div>
                                </div>

                                <div class="form-group">
                                    <h6><label class="" for="contraseña">Contraseña</label></h6>
                                    <input type="text" name="contraseña" class="form-control" id="contraseña">
                                    <div class="invalid-feedback"></div>
                                </div>

                                <button type="submit" class="btn btn-primary btn-larg w-100">Entrar</button>

                                <span class="mt-3 d-block text-center text-white">
                                    ¿No tienes cuenta? <a href="usuario.php" id="btn_registrar">Registrarse</a>.
                                </span>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Información -->
<div class="container">

    <!-- Separador -->
    <div class="d-flex justify-content-center mt-3" id="separador">
        <img src="../../publico/imagenes/divisor-1.png" alt="separador" style="transform: scale(.67); opacity: .7;">
            <a href="#imformacion" class="text-muted mt-3 text-SansiteSwashed" style="font-size: 1em!important">Ver más</a>
        <img src="../../publico/imagenes/divisor-1.png" alt="separador" style="transform: scale(.67); opacity: .7;">
    </div>

    <br><br><br><br>
    <div class="container marketing" id="imformacion">
    <br><br>
        <!-- Three columns of text below the carousel -->
        <div class="row text-center">
          <div class="col-lg-4">
            <img class="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
            <h2>Heading</h2>
            <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod. Nullam id dolor id nibh ultricies vehicula ut id elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Praesent commodo cursus magna.</p>
            <p><a class="btn btn-secondary" href="#" role="button">View details »</a></p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <img class="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
            <h2>Heading</h2>
            <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Cras mattis consectetur purus sit amet fermentum. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh.</p>
            <p><a class="btn btn-secondary" href="#" role="button">View details »</a></p>
          </div><!-- /.col-lg-4 -->
          <div class="col-lg-4">
            <img class="rounded-circle" src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" alt="Generic placeholder image" width="140" height="140">
            <h2>Heading</h2>
            <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
            <p><a class="btn btn-secondary" href="#" role="button">View details »</a></p>
          </div><!-- /.col-lg-4 -->
        </div><!-- /.row -->


        <!-- START THE FEATURETTES -->

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7">
            <h2 class="featurette-heading">First featurette heading. <span class="text-muted">It'll blow your mind.</span></h2>
            <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
          </div>
          <div class="col-md-5">
            <img class="featurette-image img-fluid mx-auto" data-src="holder.js/500x500/auto" alt="500x500" style="width: 500px; height: 500px;" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22500%22%20height%3D%22500%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20500%20500%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1762ea6233a%20text%20%7B%20fill%3A%23AAAAAA%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A25pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1762ea6233a%22%3E%3Crect%20width%3D%22500%22%20height%3D%22500%22%20fill%3D%22%23EEEEEE%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22185.1171875%22%20y%3D%22261.1%22%3E500x500%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true">
          </div>
        </div>

        <hr class="featurette-divider">

        <div class="row featurette">
          <div class="col-md-7 order-md-2">
            <h2 class="featurette-heading">Oh yeah, it's that good. <span class="text-muted">See for yourself.</span></h2>
            <p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
          </div>
          <div class="col-md-5 order-md-1">
            <img class="featurette-image img-fluid mx-auto" data-src="holder.js/500x500/auto" alt="500x500" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22500%22%20height%3D%22500%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20500%20500%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_1762ea6233c%20text%20%7B%20fill%3A%23AAAAAA%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A25pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_1762ea6233c%22%3E%3Crect%20width%3D%22500%22%20height%3D%22500%22%20fill%3D%22%23EEEEEE%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22185.1171875%22%20y%3D%22261.1%22%3E500x500%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true" style="width: 500px; height: 500px;">
          </div>
        </div>

        <hr class="featurette-divider">

        <!-- /END THE FEATURETTES -->

      </div>

</div>


<style>
    #master {
        transform: translateY(6px);
        background-image: url('../../publico/imagenes/bg-6.jpg');
        background-repeat: no-repeat;
        background-position: bottom;
        filter: grayscale(.2) brightness(1.1);
        background-size: cover;
        border: none!important;
    }

    #card_login {
        backdrop-filter: blur(6px) brightness(1.1);
    }

    #card_login {
        border-radius: 22px;
        box-shadow: 1px 6px 12px rgba(0,0,0,0.15);
    }

    @media (max-width: 576px) {
        #contenedor {
            width: 100% !important;
        }
    }
</style>

<script>
    $(document).ready(function(){
    // Add smooth scrolling to all links
    $("a").on('click', function(event) {

        // Make sure this.hash has a value before overriding default behavior
        if (this.hash !== "") {
        // Prevent default anchor click behavior
        event.preventDefault();

        // Store hash
        var hash = this.hash;

        // Using jQuery's animate() method to add smooth page scroll
        // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
        $('html, body').animate({
            scrollTop: $(hash).offset().top
        }, 800, function(){
    
            // Add hash (#) to URL when done scrolling (default click behavior)
            window.location.hash = hash;
        });
        } // End if
    });
    });
</script>

<?php
include_once("estructura/pie.php");
?>