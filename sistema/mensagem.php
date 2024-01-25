<?php
include 'cabecalho.php';
$tipo_pag = 4;

$SQL_contato_l = $db->select("contato", '', array('Contato'));
$contato_l = mysqli_num_rows($SQL_contato_l);
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
                    <li class="active">Mensagem</li>
                </ul>
            </div>

            <div class="page-content">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Mensagem</h1>
                    </div>
                </div>

                <div class="page-content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="tabbable">
                                        <ul id="inbox-tabs" class="inbox-tabs nav nav-tabs padding-16 tab-size-bigger tab-space-1">
                                            <li class="active">
                                                <a data-toggle="tab" href="#inbox" data-target="inbox">
                                                    <i class="blue ace-icon fa fa-inbox bigger-130"></i>
                                                    <span class="bigger-110">Mensagens</span>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="tab-content no-border no-padding">
                                            <div id="inbox" class="tab-pane in active">
                                                <div class="message-container">
                                                    <div id="id-message-list-navbar" class="message-navbar clearfix">
                                                        <div class="message-bar">
                                                            <div class="message-infobar" id="id-message-infobar">
                                                                <span class="blue bigger-150">Mensagens</span>
                                                                <?php
                                                                $sql_contato_n = $db->select("contato", "Lido = 0");
                                                                $contato_n = mysqli_num_rows($sql_contato_n);
                                                                ?>
                                                                <span class="grey bigger-110">(<?php echo $contato_n ?> mensagens não lidas)</span>
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <div class="messagebar-item-right">
                                                                <div class="inline position-relative">
                                                                    <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                                                                        Ordenação &nbsp; <i class="ace-icon fa fa-caret-down bigger-125"></i>
                                                                    </a>

                                                                    <ul class="dropdown-menu dropdown-lighter dropdown-menu-right dropdown-100">
                                                                        <li id="data" class="ordenacao">
                                                                            <a href="#">
                                                                                <i class="ace-icon fa fa-check ord"></i> Data
                                                                            </a>
                                                                        </li>

                                                                        <li id="nome" class="ordenacao">
                                                                            <a href="#">
                                                                                <i class="ace-icon fa fa-check ord2"></i> Nome
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>

                                                            <div class="nav-search minimized">
                                                                <form class="form-search">
                                                                    <span class="input-icon">
                                                                        <input type="text" id="search-nodata" name="search-nodata" data-list=".nodata_list" autocomplete="off" class="input-small nav-search-input" placeholder="Procure aqui ..." />
                                                                        <i class="ace-icon fa fa-search nav-search-icon"></i>
                                                                    </span>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="message-list-container">
                                                        <div class="message-list vertical nodata_list" id="message-list">
                                                        </div>
                                                    </div>

                                                    <div class="message-footer clearfix">
                                                        <div class="pull-left"> <?php echo $contato_l ?> mensagens total </div>
                                                        <div id="paginacao"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'rodape.php' ?>