<?php
    include('sistema/config/classes.php');
    include('sistema/config/instancias.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <title>YCK'S</title>
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta charset="utf-8">
        <meta name="author" content="Marcos Alves">
        <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        
        <!-- Favicons -->
        <link rel="shortcut icon" href="images/favicon.png">
        <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
        <link rel="apple-touch-icon" sizes="72x72" href="images/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="114x114" href="images/apple-touch-icon-114x114.png">
        
        <!-- CSS -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/style-responsive.css">
        <link rel="stylesheet" href="css/animate.min.css">
        <link rel="stylesheet" href="css/vertical-rhythm.min.css">
        <link rel="stylesheet" href="css/owl.carousel.css">
        <link rel="stylesheet" href="css/magnific-popup.css">
        <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
        <link href="css/royalslider.css" rel="stylesheet">
        
        <!-- Font -->
        <link href='http://fonts.googleapis.com/css?family=Dancing+Script' rel='stylesheet' type='text/css'>
        <link href="http://allfont.net/allfont.css?fonts=p22-corinthia" rel="stylesheet" type="text/css" />  <!-- font-family: 'P22 Corinthia', arial; -->

        <style>
            .Legenda{
                display:none;
            }

            .navbar{
                background: #00a859 !important;
                /*border-color: #00a859 !important; */
            }


        </style>        

    </head>
    <body class="appear-animate">
           <!-- Load Facebook SDK for JavaScript -->
    <div id="fb-root"></div>
	<script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.4";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>
    
    
        <div class="overlay-box-promocao"></div>
        <div class="box-promocao">
        <figure>
        <a href="http://www.safveiculos.com.br/promocoes">
        <img class="img-responsive" onclick="slide_stop()" alt="Novo Uno Vivace" src="http://www.safveiculos.com.br/uploads/promocao/saf_popup_500x500px_092015-01.png">
        </a>
        </figure>
        <span class="close-box-promocao"></span>
        </div>
        <!-- Page Loader -->        
        <div class="page-loader">
            <div class="loader">Carregando...</div>
        </div>
        <!-- End Page Loader -->
        
        <!-- Page Wrap -->
        <div class="page" id="top">
            <!-- Navigation panel -->
            <nav class="main-nav dark transparent stick-fixed">
                <div class="full-wrapper relative clearfix">
                    <!-- Logo ( * your text or image into link tag *) -->
                    <div class="nav-logo-wrap local-scroll">
                        <a href="#top" class="logo" style="padding-top:5px;">
                            <img src="images/logo-white.png"  alt="" />
                        </a>
                    </div>
                    <div class="mobile-nav">
                        <i class="fa fa-bars"></i>
                    </div>
                    <!-- Main Menu -->
                    <div class="inner-nav desktop-nav">
                        <ul class="clearlist scroll-nav local-scroll">
                            <li class="active"><a href="#top">Home</a></li>
                            <li><a href="institucional.php">Institucional</a></li>
                            <li><a href="#destaques">Acontece</a></li>
                            <li><a href="#campanha">Campanha</a></li>
                            <li><a href="#lookbook">Look Book</a></li>
                            <li><a class="mn-has-sub" href="#">Mídia</a>
                            	<ul class="mn-sub">
                                	<li><a href="#">Vídeos</a></li>
                                    <li><a href="#">Revistas</a></li>
                                    <li><a href="#">Folhetos</a></li>
                                    <li><a href="#">Jornais</a></li>
                                </ul>                            
                            </li>
                            <li><a href="#" style="font-family: 'p22_corinthiaregular', arial; color:#f0a1a5; text-shadow: 1px 1px 1px #000; font-size:40px; text-transform:none; background-image:url(images/blog.png); background-repeat:no-repeat; background-size: 25px; background-position: 100% 40%;">Blog</a></li>
                            <li><a href="lojas.php">Lojas</a></li>
                            <li><a href="contato.php">Contato</a></li>
                            
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navigation panel --> 