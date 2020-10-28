<?php 

function data_submitted() {
	$_AAux= array();
    if (!empty($_POST)) 
    	$_AAux =$_POST;
    else 
		if(!empty($_GET)) {
            $_AAux =$_GET;
		}
	if (count($_AAux)){
		foreach ($_AAux as $indice => $valor) {
				if ($valor=="")
                	$_AAux[$indice] = 'null'	;
			}
	}
	return $_AAux;

}

function tipo_archivo($ext)
{
	$salida = false;
	if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'gif')
	{
		$salida = 'imagen';
	} elseif ($ext == 'doc' || $ext == 'docm' || $ext == 'docx' || $ext == 'jpg')
	{
		$salida = 'documento';
	} elseif ($ext == 'pdf')
	{
		$salida = 'pdf';
	} elseif ($ext == 'xlm' || $ext == 'xlms' || $ext == 'xlsb' || $ext == 'xls')
	{
		$salida = 'xlm';
	} elseif ($ext == 'zip' || $ext == 'rar')
	{
		$salida = 'zip';
	}

	return $salida;
}

function icono_archivo($tipo)
{
	$salida = "file";
	switch ($tipo)
	{
		case "imagen":
			$salida = "image";
			break;
		case "documento":
			$salida = "file-word";
			break;
		case "pdf":
			$salida = "file-pdf";
			break;
		case "xls":
			$salida = "file";
			break;
		case "zip":
			$salida = "file-archive";
			break;
	}
	return $salida;
}

function limpiarRuta($string)
{
	return preg_replace('#/+#', '/', $string);
}


spl_autoload_register(function ($clase) {
	echo "Cargamos la clase  ".$clase."<br>" ;
	$directorys = array(
		$GLOBALS['ROOT'].'modelo/',
		$GLOBALS['ROOT'].'control/',
	);
   // print_r($directorys) ;
	foreach($directorys as $directory){
	  if(file_exists($directory.$clase . '.php')){  
			  // echo "se incluyo".$directory.$class_name . '.php';
			require_once($directory.$clase . '.php');
			return;
		}           
	}

   
});

?>