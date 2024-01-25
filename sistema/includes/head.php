<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Painel de administração Makeweb<?php echo ((isset($Titulo) && $Titulo != "")?" - ".$Titulo:""); ?></title>
    <link href="<?php echo $Config["Url"]; ?>css/kube.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $Config["Url"]; ?>css/sistema.css" rel="stylesheet" type="text/css" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo $Config["Url"]; ?>favicon.ico">
    
	<?php if(isset($_SESSION[$Config["PrefixoSessao"]."Layout"]) && $_SESSION[$Config["PrefixoSessao"]."Layout"] == 2) { ?>
		<script> 
			$(document).ready(function() { 
				$(".MaxWid").css("width", "1366px").css("margin", "0 auto");
			});
        </script>
    <?php }?>
