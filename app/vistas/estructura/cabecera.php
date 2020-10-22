<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?PHP $Titulo?></title>

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

    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>

</head>
<body style="height: 100vh">

    <!-- Cabecera -->
    <div class="navbar navbar-dark bg-dark flex-md-nowrap p-1 shadow text-light"> 
        <div class="w-100 d-flex justify-content-between">
            <div class="">
                <h5 class="ml-3 pt-2"><a href="index.php" class="text-white">FiDrive</a></h5>
            </div>
            <div class="mr-3 pt-2">
                <a href="https://github.com/ezeveritta/FAI-2172FiDrive" class="text-white">GitHub</a>
            </div>
        </div>
    </div>
   
    <?php  
    include_once("../../../configuracion.php");
    include_once("menu.php");
    ?>