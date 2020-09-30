<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?PHP $Titulo?></title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../../../publico/css/bootstrap/bootstrap.min.css">

    <!-- Iconos -->
    <link rel="stylesheet" href="../../../publico/css/iconos/all.min.css">

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