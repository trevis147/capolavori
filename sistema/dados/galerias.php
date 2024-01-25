<?php
session_start();
require_once('../config/classes.php');
require_once('../config/instancias.php');

$caminho = '../../imagem/galerias/';

$img->cria_pasta(array($caminho));

if (isset($_FILES['arquivo']) && $_FILES['arquivo'] != '') {
    $foto = $_FILES['arquivo']['name'];
    $foto_temp = $_FILES['arquivo']['tmp_name'];
    $img->upload_arquivo($foto, $foto_temp, $caminho);
}

if ($_POST["Id"] == "") {

    $db->insert('galerias', array($_POST["Titulo"], str_replace('"', "'", $_POST["Texto"]), $foto, 1), 'Titulo, Texto, Foto, Ativo');
    $msg = "Inserido_com_sucesso";
} elseif (isset($_POST['Alterar'])) {

    $db->update('galerias', array('Titulo' => $_POST["Titulo"], 'Texto' => str_replace('"', "'", $_POST["Texto"])), array('Galerias', $_POST["Id"]));
    if ($foto != '') {
        $db->update('galerias', array('Foto' => $foto), array('Galerias', $_POST["Id"]));
    }
    $msg = "Alterado_com_sucesso";
} elseif (isset($_POST["Deletar"])) {

    $db->delete('galerias', "Galerias=" . $_POST['Id']);
    $msg = "Deletado_com_sucesso";
}
?>

<script type="text/javascript">
    parent.location = "../galerias.php?msg=<?php echo $msg ?>";
</script>