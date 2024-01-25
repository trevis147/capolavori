<?php
session_start();
require_once("../config/config.php");


$sql = 'SELECT Pasta from modelo_newsletter where Modelo_newsletter = "'.$_POST['Newsletter'].'"';
$q = Query($sql,1);
$pasta = $q['Pasta'];

$caminho = '../../modelo/'.$pasta.'/images/';


$img = $_FILES['arquivo']['name'];
$path = $caminho.'/'.$img;
move_uploaded_file($_FILES['arquivo']['tmp_name'],$path);

if ($_POST["Id"] == "" && $_POST["Titulo"] != "") {
    Query("INSERT INTO `modelo_img_news`(`Titulo`,`Newsletter`,`Imagem`) VALUES  ('".$_POST["Titulo"]."','".$_POST['Newsletter']."','".$img."')");
    $msg = "Inserido com sucesso";

} elseif ($_POST["Titulo"] != "" && isset($_POST['Alterar'])) {
    mysql_query("UPDATE  `modelo_img_news` SET Titulo='" . $_POST["Titulo"] . "'  WHERE  `Modelo_img_news`=" . $_POST["Id"] . "");
    	if($img != '')
		mysql_query("UPDATE `modelo_img_news` SET Arquivo = '".$img."' WHERE `Modelo_img_news` = ".$_POST["Id"]."");
    	$msg = "Alterado com sucesso";
    
} elseif (isset($_POST["Deletar"])) {
    $resp = Query("SELECT * FROM `modelo_img_news` WHERE `Modelo_img_news`=" . $_POST["Id"] . "",1);
    
    
    unlink('../../modelo/'.$pasta.'/'.$resp['Imagem']);
    Query("DELETE FROM `modelo_img_news` WHERE `Modelo_img_news`=" . $_POST["Id"] . "");
    $msg = "Deletado com sucesso";
}

?>

<script type="text/javascript">
    parent.location = "../cadastrar-modelo.php?msg=<?php echo $msg?>";
</script>