<?php include 'cabecalho.php';
     $tipo_pag = 0;
?>

<style>
.main-content-inner{
    padding-top: 0px !important;
} 


</style>

<div class="main-container" id="main-container">

    <?php include 'menu.php'; ?>

    <div class="main-content">

        <div class="main-content-inner">

            <div class="breadcrumbs" id="breadcrumbs">

                <ul class="breadcrumb">

                   <!-- <li>

                        <i class="ace-icon fa fa-home home-icon"></i> <a href="<?php  echo $Config['Url'];    ?>">Home</a>

                    </li>-->

                    <li class="active"><i class="ace-icon fa fa-home home-icon"></i><a href="<?php  echo $Config['Url'];    ?>"> Inicio</a></li>

                </ul>

            </div>

            <div class="page-content">

                <!--<div class="row">

                    <div class="col-lg-12">

                        <h1 class="page-header">Inicio</h1>

                    </div>

                </div>-->

                <div class="row" >



                    <div class="col-lg-12">

                        <div class="panel panel-default">

                            <div class="panel-heading">

                                <i class="fa fa-bell fa-fw"></i> Cadastros realizados

                            </div>
                        <div class="row ">
                            <div class="panel-body col-md-12">
                            <?php    
                                $q = Query('SELECT Titulo,Rotulo FROM menu_sistema WHERE Ativo = 1 ORDER BY Rotulo ASC',0);
                                if(mysqli_num_rows($q) > 0){
                                    while($menu = mysqli_fetch_assoc($q)){
                            ?>
                                <div class="list-group col-md-3">
                                    
                                    <div style="margin-left:5%;">
                                        <i class="ace-icon fa fa-check "></i> <b><?php echo ucfirst(str_replace('_',' ',$menu['Rotulo'])); ?>
                                        <em>
                                           - <b><?php $cont = Query('SELECT COUNT(*) as Total FROM '.$menu['Titulo'].'',1); echo $cont['Total'];  ?></b> cadastros
                                        </em>
                                    </div>
                               
                                </div>
                            <?php  }  }  ?>
                            </div>
                        </div>

                        </div>

                    </div>


        

                </div>

            </div>

        </div>

    </div>







<?php include 'rodape.php'; ?>