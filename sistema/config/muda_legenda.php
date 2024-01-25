<?php
session_start();
require_once('config.php');
//require_once('instancias.php');

if (isset($_POST['var']) && $_POST['var'] != '') {
   Query('UPDATE galerias_fotos set Titulo = "'.$_POST['titulo'].'",Texto = "'.$_POST['texto'].'" where Galerias_fotos = "'.$_POST['var'].'"',0);
   echo '1';
}else{
	echo '0';
}

