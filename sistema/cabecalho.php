<?php include "./config/config.php";
    
    // session_start();
    // print_r($_SESSION);
    // exit;

 
    if(!isset($_SESSION['Sis545IdUsuario'])){
        session_destroy();
        header("Location: ".$Config['Url']."login.php");
        exit;
    }

    $server = $_SERVER['SERVER_NAME'];    
    $endereco = $_SERVER ['REQUEST_URI'];

?>
<!DOCTYPE html>
<style>

.main-container{
    margin-top: 7%;
}



#navbar{
    background-color: #041e42;
    box-shadow: 0 2px 8px #152f53;
    /*margin-bottom: 30px;*/
    padding: 0;
    padding-left: 0px;
    position: fixed;
    top: 0;
    left: 0;
   /* height: 90px;*/
    width: 100%;
    display: block;
    z-index: 2000;
}



.pagination > .active > a, .pagination > .active > a:focus, .pagination > .active > a:hover, .pagination > .active > span, .pagination > .active > span:focus, .pagination > .active > span:hover {
    z-index: 2;
    color: #fff;
    background-color: #000000 !important;
    border-color: #000000 !important;
    cursor: default;
}

    .menu{

        display:none !important;

    }


 



    .Titulo{

    	margin-top: 5px;

    }

   /* .Legenda{
        display:none !important;
    }


    .Alterar_leg{
        display:none !important;
    }*/


    .navbar{   
       /* background: #d35a2a  !important;*/
       background: linear-gradient(45deg, #18161b 0%, #293846 100%) !important;
    }

</style>

<html lang="pt">

    <head>

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

        <meta charset="utf-8" />

    
        <title>Makeweb</title>

       
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

        <!-- bootstrap & fontawesome -->

        <link rel="stylesheet" href="<?php echo $Config['Url'];     ?>assets/css/bootstrap.min.css" />

        <link rel="stylesheet" href="<?php echo $Config['Url'];     ?>assets/css/ace.min.css" />

        <link rel="stylesheet" href="<?php echo $Config['Url'];     ?>assets/css/dropzone.css" />

		<link rel="stylesheet" href="<?php echo $Config['Url'];     ?>assets/css/styles.css" />

		<link rel="stylesheet" href="<?php echo $Config['Url'];     ?>assets/css/daterangepicker-bs3.css" />

        <link rel="stylesheet" href="<?php echo $Config['Url'];     ?>assets/font-awesome/4.4.0/css/font-awesome.min.css" />

        <link rel="stylesheet" href="<?php echo $Config['Url'];     ?>assets/fonts/fonts.googleapis.com.css" />

        <link href="<?php echo $Config["Url"]; ?>css/jquery.dataTables.css" rel="stylesheet" type="text/css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

        <link href="<?php echo $Config['Url'];     ?>multi_select/css/multi-select.css" media="screen" rel="stylesheet" type="text/css">

        <script src="<?php echo $Config['Url'];     ?>multi_select/js/jquery.multi-select.js" type="text/javascript"></script>

        <link href="<?php echo $Config['Url'];    ?>css/sweetalert.css" rel="stylesheet"> 

        

    </head>

    <body class="no-skin">

        <div id="navbar" class="navbar navbar-default">

            <div class="navbar-container" id="navbar-container">

                <div class="navbar-header pull-left">

                    <a href="<?php  echo $Config['Url'];   ?>" class="navbar-brand">

                        <h2>

                            <img src="<?php echo $Config['Url'];   ?>img/demo-1/logo-makeweb.png"> Sistema de gerenciamento
                
                        </h2>

                    </a>

                </div>


                <div class="navbar-buttons navbar-header pull-right" role="navigation">

                    <ul class="nav ace-nav">

                        <li class="green">

                            <ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">

                                <li class="dropdown-header">
                                    <i class="ace-icon fa fa-envelope-o"></i> <?php echo $cont_mensagem ?> Mensagens
                                </li>

                                <li class="dropdown-content">

                                    <ul class="dropdown-menu dropdown-navbar">

                                        <li>
                                                <a href="mensagem_pessoal.php?id=<?php echo $mensagem['Contato']?>" class="clearfix">

                                                    <span class="msg-body">

                                                        <span class="msg-title">

                                                            <span class="blue"><?php echo $mensagem['Nome'] ?>:</span>

                                                            <?php echo substr($mensagem['Mensagem'], 0, 60) ?>

                                                        </span>

                                                        <span class="msg-time">

                                                            <i class="ace-icon fa fa-clock-o"></i>

                                                            <span>enviado <?php echo $mensagem['Hora'] ?></span>

                                                        </span>

                                                    </span>

                                                </a> 

                                            <?php //} ?>

                                        </li>

                                    </ul>

                                </li>

                                <li class="dropdown-footer">

                                    <a href="mensagem.php">

                                        Ver todas mensagens <i class="ace-icon fa fa-arrow-right"></i>

                                    </a>

                                </li>

                            </ul>   

                        </li>

                        <li class="blue">

                            <a data-toggle="dropdown" href="#" class="dropdown-toggle">

                                <i class="ace-icon glyphicon glyphicon-user"></i>

                                <i class="ace-icon fa fa-caret-down"></i>    
                            </a>

                            <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                                <?php if(isset($_SESSION['Nivel']) && ($_SESSION['Nivel']==1)){   ?>
                                    <li>
                                        <a href="<?php  echo $Config['Url'];  ?>usuarios">
                                            <i class="ace-icon fa fa-user"></i> Editar Usuario
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                <?php  }   ?> 


                                                                   
    
                              <!--  <li>
                                    <a href="<?php echo $Config['UrlSite'];   ?>scripts/integra_xml.php" target="_blank">
                                        <i class="ace-icon fa fa-gear"></i> Atualiza Veiculos
                                    </a>
                                </li>


                                <li class="divider"></li>
                                <li>
                                    <a href="<?php echo $Config['UrlSite'];   ?>scripts/integra_xml_fotos.php" target="_blank">
                                        <i class="ace-icon fa fa-gear"></i> Atualiza Fotos
                                    </a>
                                </li>



                                <li class="divider"></li>

                                <li>
                                    <a href="<?php echo $Config['UrlSite'];   ?>scripts/integra_xml_dados.php" target="_blank">
                                        <i class="ace-icon fa fa-gear"></i> Atualiza Dados
                                    </a>
                                </li>-->

                              


                                    <li>
                                        <a href="<?php echo $Config['Url'];    ?>config/sair.php">
                                            <i class="ace-icon fa fa-power-off"></i> Logout
                                        </a>
                                    </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>