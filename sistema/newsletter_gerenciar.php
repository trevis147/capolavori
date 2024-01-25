<?php include 'cabecalho.php' ?>

<link href="css/flick/jquery-ui-1.10.4.custom.css" rel="stylesheet">
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script src="js/jquery-ui-1.10.4.custom.js"></script>

<script>
    $(function() {
        $("#datepicker").datepicker();
    });
</script>

<?php


if (isset($_GET['Id']) && $_GET['Id'] != '') {
    $SQL_noticias = Query("SELECT * FROM modelo_newsletter WHERE Modelo_newsletter = '" . $_GET['Id'] . "'");
    $Noticias = mysqli_fetch_assoc($SQL_noticias);
}


?>

<div class="page-content">
    <div class="row">
    <?php
        $Menu_atual = 80;
        include 'menu.php';
    ?>

        <div class="col-md-8">
            <div class="content-box-large">
                <div class="panel-heading">
                    <div class="panel-title">Modelo Newsletter -<?php
                        if (isset($_GET['Id']) && $_GET['Id'] != '') {
                            echo $Noticias['Titulo'];
                        } else {
                            ?> Novo <?php } ?></div>
                </div>
                <div class="panel-body">
                    <form method="post" action="dados/modelo_gerenciar.php" class="form-horizontal" role="form" enctype="multipart/form-data">
                        <input type="hidden" name="Id" value="<?php echo $Noticias['Modelo_newsletter']; ?>" />


                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Título do Modelo</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="Titulo" placeholder="Titulo" value="<?php echo $Noticias['Titulo'] ?>">
                            </div>
                        </div>

                        <!-- fim alerta -->
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Arquivo HTML</label>
                            <div class="col-md-10">
                                <input class="btn btn-default" type="file" name="arquivo">
                            </div>
                        </div>


                        
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <?php if (isset($_GET['Id']) && $_GET['Id'] != '') { ?>
                                    <!--<button name="Alterar" type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-refresh"></i> Alterar</button>-->
                                    <button name="Deletar" type="submit" class="btn btn-danger"><i class="glyphicon glyphicon-remove"></i> Deletar</button>
                                <?php } else { ?>
                                    <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-save"></i> Cadastrar</button>
                                <?php } ?>
                                <button type="button" onClick="location.href = 'cadastrar-modelo.php'" class="btn btn-default"> Cancel </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'rodape.php' ?>