<?php
session_start();
require_once("../config/config.php");

	function removeAcentos($string, $separator = '-') {
        $accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
        $special_cases = array('&' => 'and');
        $string = mb_strtolower(trim($string), 'UTF-8');
        $string = str_replace(array_keys($special_cases), array_values($special_cases), $string);
        $string = preg_replace($accents_regex, '$1', htmlentities($string, ENT_QUOTES, 'UTF-8'));
        $string = preg_replace("/[^a-z0-9]/u", "$separator", $string);
        $string = preg_replace("/[$separator]+/u", "$separator", $string);
        return $string;
    }



//$d = explode('/', $_POST['Data']);
//$Data = $d[2].'-'.$d[1].'-'.$d[0];


$pasta =  removeAcentos($_POST["Titulo"]);



$caminho = '../../modelo/';
$caminho = $caminho.$pasta;

if(!file_exists($caminho)){
    mkdir($caminho,0777);
}

$html = $_FILES['arquivo']['name'];
$path = $caminho.'/'.$html;
move_uploaded_file($_FILES['arquivo']['tmp_name'],$path);


$caminho = '../../modelo/';
$caminho2 = $caminho.$pasta.'/images';

if(!file_exists($caminho2)){
    mkdir($caminho2,0777);
}



if ($_POST["Id"] == "" && $_POST["Titulo"] != "") {
    Query("INSERT INTO `modelo_newsletter`(`Titulo`,`Pasta`,`Arquivo`) VALUES  ('".$_POST["Titulo"]."','".$pasta."','".$html."')");
    	$msg = "Inserido com sucesso";

} elseif ($_POST["Titulo"] != "" && isset($_POST['Alterar'])) {
    mysql_query("UPDATE  `modelo_newsletter` SET Titulo='" . $_POST["Titulo"] . "'  WHERE  `Modelo_newsletter`=" . $_POST["Id"] . "");
    	if($html != '')
		mysql_query("UPDATE `modelo_newsletter` SET Arquivo = '".$html."' WHERE `Modelo_newsletter` = ".$_POST["Id"]."");
    	$msg = "Alterado com sucesso";
    
} elseif (isset($_POST["Deletar"])) {
    $resp = Query("SELECT * FROM `modelo_newsletter` WHERE `Modelo_newsletter`=" . $_POST["Id"] . "",1);
    $pasta = $resp['Pasta'];
    $new_name = $pasta.'_'.'apagada';
    rename('../../modelo/'.$pasta,'../../modelo/'.$new_name);
    Query("DELETE FROM `modelo_newsletter` WHERE `Modelo_newsletter`=" . $_POST["Id"] . "");
    $msg = "Deletado com sucesso";
}

?>

<script type="text/javascript">
    parent.location = "../cadastrar-modelo.php?msg=<?php echo $msg?>";
</script>