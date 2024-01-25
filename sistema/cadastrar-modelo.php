<?php include 'cabecalho.php' ?>



<div class="page-content">
    <div class="row">
        <?php
        $Menu_atual = 80;
        include 'menu.php';
        ?>

        <div class="col-md-9">
            <div class="content-box-large">
                <div class="panel-heading">
                    <div class="panel-title">Cadastro de Modelo - Newsletter</div>
                </div><br><br>
                <?php if (isset($_GET['msg']) && $_GET['msg'] == 'Alterado com sucesso') { ?>
                    <span style="font-weight:bold; font-size:14px; margin-left:17px;"><i class="glyphicon glyphicon-refresh"></i> Alterado com sucesso!</span>
                <?php } elseif (isset($_GET['msg']) && $_GET['msg'] == 'Deletado com sucesso') { ?>
                    <span style="font-weight:bold; font-size:14px; margin-left:17px;"><i class="glyphicon glyphicon-remove"></i> Deletado com sucesso!</span>
                <?php } ?>
                <div class="panel-body">
                    <table cellpadding="0" cellspacing="0" border="0" class="table table-striped" id="example">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Titulo</th>
                                <th>Imagens</th>
                                <th>Editar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $SQL_paginas = mysqli_query("SELECT Titulo,Modelo_newsletter FROM modelo_newsletter ORDER BY Modelo_newsletter ASC");
                            while ($Pagina = mysqli_fetch_assoc($SQL_paginas)) {
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $Pagina['Modelo_newsletter'] ?></td>
                                    <td><?php echo $Pagina['Titulo'] ?></td>
                                    <td><a href="imagens_newsletter.php?Id=<?php echo $Pagina['Modelo_newsletter']; ?>"><img src="images/edita.png" alt="Editar" title="Editar"></a></td>
                                    <td><a href="newsletter_gerenciar.php?Id=<?php echo $Pagina['Modelo_newsletter']; ?>"><img src="images/edita.png" alt="Editar" title="Editar"></a></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <button class="btn btn-default" onClick="location.href = 'newsletter_gerenciar.php'"><i class="glyphicon glyphicon-plus"></i> Inserir</button>
            </div>
        </div>
    </div>
</div>

<?php include 'rodape.php' ?>