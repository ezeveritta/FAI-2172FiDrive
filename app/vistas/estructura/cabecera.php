<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?PHP $Titulo ?></title>

    <!-- Dependencias -->
    <script src="../../../publico/js/jquery/jquery-3.5.1.min.js"></script>
    <script src="../../../publico/js/popper/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="../../../publico/js/bootstrap/bootstrap.bundle.min.js"></script>


    <!-- Bootstrap -->
    <link rel="stylesheet" href="../../../publico/css/bootstrap/bootstrap.min.css">
    <script src="../../../publico/js/bootstrap/bootstrapValidator.js"></script>

    <!-- Iconos -->
    <link rel="stylesheet" href="../../../publico/css/iconos/all.min.css">

    <!-- Fuentes -->
    <link rel="stylesheet" href="../../../publico/css/fonts/Satisfy-Regular.css">
    <style>
        @font-face {
            font-family: Satisfy;
            src: '../../../publico/css/fonts/Satisfy-Regular.ttf';
        }

        input:focus,
        textarea:focus,
        select:focus,
        button:focus {
            outline: none !important;
            box-shadow: inset 0 -1px 0 #ddd;
        }
    </style>

    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

</head>

<body style="height: 100vh">

    <!-- Cabecera -->
    <div class="navbar navbar-light bg-white flex-md-nowrap p-1 text-light" style="box-shadow: 3px 0px 8px rgba(0,0,0,0.1)">
        <div class="w-100 d-flex justify-content-between">
            <div class="">
                <h5 class="ml-5 pt-2"><a href="../contenido" class="text-muted" style="font-family: Satisfy">FiDrive</a></h5>
            </div>
            <div class="mr-3 pt-2">
                <a href="https://github.com/ezeveritta/FAI-2172FiDrive" class="text-muted mr-3">GitHub</a>
            </div>
        </div>
    </div>

    <?php
    include_once("../../../configuracion.php");
    include_once("menu.php");
    ?>