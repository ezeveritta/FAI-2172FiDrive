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

/**
 * Ésta función elimina las barras dobles
 * @param string $string Texto a limpiar
 * @return string
 */
function limpiarRuta($string)
{
	return preg_replace('#/+#', '/', $string);
}

/**
 * Ésta función acorta un string para que no sobrepase el tamaño de su contenedor html
 * @param string $string Texto a acortar
 * @return string
 */
function texto_limitado($string, $largo = 18)
{
	return mb_strimwidth($string, 0, $largo, '...');
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

/**
 * Función extraída de internet, obtiene el tamaño (peso) de una carpeta incluida subcarpetas..
 */
function folderSize($dir)
{
	$size = 0;

	foreach (glob(rtrim($dir, '/') . '/*', GLOB_NOSORT) as $each) {
		$size += is_file($each) ? filesize($each) : folderSize($each);
	}

	return $size;
}

?>