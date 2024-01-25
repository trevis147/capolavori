<?php
require_once('classes.php');
require_once('instancias.php');

$tipo = $_GET['tipo'];
$pag = $_GET['pag'];
$maximo = $_GET['maximo'];
$inicio = ($pag * $maximo) - $maximo;

if ($tipo == 'listagem') {
    $sql = "SELECT * FROM contato ORDER BY Data LIMIT $inicio, $maximo";
    $query = $db->query($sql);

    if ($db->num_rows($query) == 0) {
        echo("Nenhum cadastro encontrado");
    }
    while ($res = mysql_fetch_array($query)) {
        ?>
        <div class="message-item <?php if ($res['Lido'] == 0) { ?>message-unread<?php } ?>">
            <label class="inline">
                <input type="checkbox" class="ace" />
                <span class="lbl"></span>
            </label>
            <a href="mensagem_pessoal.php?id=<?php echo $res['Contato']; ?>">
                <span class="sender" title="<?php echo $res['Nome'] ?>">
                    <?php echo $res['Nome'] ?>
                </span>
            </a>
            <span class="time"><?php echo $res['Hora'] ?></span>
            <a href="mensagem_pessoal.php?id=<?php echo $res['Contato']; ?>">
                <span class="summary">
                    <span class="badge <?php if ($res['Lido'] == 0) { ?>badge-danger<?php } else { ?>badge-white<?php } ?> mail-tag"></span>
                    <span class="text">
                        <?php echo substr($res['Mensagem'], 0, 60) ?>
                    </span>
                </span>
            </a>
        </div>
        <?php
    }
} else if ($tipo == 'contador') {
    $sql_res = $db->select("contato"); //consulta no banco
    $contador = mysql_num_rows($sql_res); //Pegando Quantidade de itens
    echo $contador;
} else {
    echo "Solicitação inválida";
}
?>