<?php
include 'cabecalho.php';
$tipo_pag = 80;
?>



<div class="main-container" id="main-container">

    <?php include 'menu.php'; ?>

    <div class="main-content">
        <div class="main-content-inner">
            <div class="breadcrumbs" id="breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <i class="ace-icon fa fa-home home-icon"></i>
                        <a href="index.php">Home</a>
                    </li>
                    <li class="active">Imagens Newsletter</li>
                </ul>
            </div>

            <div class="page-content">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Imagens Newsletter</h1>
                    </div>
                </div>

                <a href="img_news_gerenciar.php?News=<?php  echo  $_GET['Id']; ?>" class="btn btn-primary" style="margin-bottom:15px;">Cadastrar nova Imagens Newsletter</a>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Registros <a style="cursor:pointer;" data-toggle="tooltip" data-placement="top" data-original-title="Caso queira editar a noticia, clique em EDITAR."><i class="fa fa-info-circle"></i></a>
                            </div>

                            <div class="panel-body">
                                <div class="dataTable_wrapper">
                                    <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Titulo</th>
                                                <th>Editar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $SQL = mysqli_query("SELECT * FROM modelo_img_news where Newsletter = ".$_GET['Id']." ORDER BY Titulo ASC");
                                            while ($pagina = mysqli_fetch_assoc($SQL)) {
                                                ?>
                                                <tr>
                                                    <td><?php echo $pagina['Modelo_img_news'] ?></td>
                                                    <td><?php echo $pagina['Titulo'] ?></td>
                                                    <td class="center"><a href="img_news_gerenciar.php?Id=<?php echo $pagina['Modelo_img_news'] ?>"><img src="img/editar_24.png" /></a></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'rodape.php' ?>