<?php include('config/config.php'); //header('Content-Type: text/html; charset=utf-8');  ?> 

<!DOCTYPE html>
<html lang="pt">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>Login - Makeweb</title>
        <meta name="description" content="Sistema de Administração do Sistema" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <link rel="stylesheet" href="<?php echo $Config['Url'];   ?>assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo $Config['Url'];   ?>assets/font-awesome/4.2.0/css/font-awesome.min.css" />
        <link rel="stylesheet" href="<?php echo $Config['Url'];   ?>assets/fonts/fonts.googleapis.com.css" />
        <link rel="stylesheet" href="<?php echo $Config['Url'];   ?>assets/css/ace.min.css" />
        <link href="<?php echo $Config['Url'];   ?>css/sweetalert.css" rel="stylesheet"> 
    </head>
    <body class="login-layout">
        <div class="main-container">
            <div class="main-content">
                <div class="row">
                    <div class="col-sm-10 col-sm-offset-1">
                        <div class="login-container">
                            <div class="center" style="background-color:#000000;">
                                <h1>    
                                    <img  class="center" src="<?php echo $Config['Url'];   ?>img/demo-1/logo-makeweb.png" class="img-responsive" />
                                    <br>
                                    <span class="red" id="errolog">Usuário ou senha errados!</span>
                                </h1>
                        </div>
                        <div class="space-6"></div>
                            <div class="position-relative">
                                <div id="login-box" class="login-box visible widget-box no-border">
                                    <div class="widget-body">
                                        <div class="widget-main">
                                            <h4 class="header blue lighter bigger">
                                                <i class="ace-icon fa fa-coffee green"></i> Sistema
                                            </h4>
                                            <div class="space-6"></div>
                                            <form id="formlogin">
                                                <fieldset>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right"> 
                                                            <input type="text" class="form-control" placeholder="Email" name="usuario" id="usuario" />
                                                            <i class="ace-icon fa fa-user"></i>
                                                        </span>
                                                    </label>
                                                    <label class="block clearfix">
                                                        <span class="block input-icon input-icon-right">
                                                            <input type="password" class="form-control" placeholder="Senha" name="senha" id="senha" />
                                                            <i class="ace-icon fa fa-lock"></i>
                                                        </span>
                                                    </label>
                                                    <div class="space"></div>
                                                    <div class="clearfix">
                                                        <button type="submit" class="width-35 pull-left btn btn-sm btn-primary">
                                                            <i class="ace-icon fa fa-key"></i>
                                                            <span class="bigger-110">Login</span>
                                                        </button>
                                                        <button type="button" class="pull-right btn btn-sm btn-primary" id="Forgotten">
                                                           Esqueceu a senha ?
                                                        </button>
                                                    </div>
                                                    <div class="space-4"></div>
                                                </fieldset>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="<?php echo $Config['Url'];    ?>js/sweetalert.min.js" ></script> 

        <script type="text/javascript">
            $(document).ready(function () {

                $('#Forgotten').on('click',function(){      
                    var usuario = '';
                    usuario = $('#usuario').val();
                    if(usuario!=''){
                        $.ajax({ //Função AJAX
                            url: "config/reset-pwd.php", //Arquivo php
                            type: "post", //Método de envio
                            data: "login="+usuario, //Dados
                            success: function (result) { //Sucesso no AJAX
                                if(result == 1){
                                     swal({   
                                        title: "",
                                        text: "Uma nova <b>Senha</b> foi gerada e enviada para o email informado.",
                                        type: "success",
                                        html: true,
                                        confirmButtonColor: "#000000",
                                        showLoaderOnConfirm: true,
                                        closeOnConfirm: true
                                      }, function(isConfirm){    
                                          if(isConfirm){   
                  
                                          }   
                                     }); 
                                }else if(result == 5){
                                     swal({   
                                        title: "",
                                        text: "As configurações de envio de emails ainda não foram configuradas para que esta funcionalidade seja usada.",
                                        type: "warning",
                                        confirmButtonColor: "#000000",
                                        showLoaderOnConfirm: true,
                                        closeOnConfirm: true
                                      }, function(isConfirm){    
                                          if(isConfirm){   
                                            $('#Forgotten').hide();
                                          }   
                                     });
                                }else{
                                    swal({   
                                        title: "",
                                        text: "Houveram erros.",
                                        type: "error",
                                        confirmButtonColor: "#ff0000",
                                        showLoaderOnConfirm: true,
                                        closeOnConfirm: true
                                      }, function(isConfirm){    
                                          if(isConfirm){   
                  
                                          }   
                                     }); 
                                }
                            }
                        });
                        return false;
                    }else{ 
                        swal({   
                            title: "",
                            text: "Preencha o campo <b>Usuário</b>, uma nova senha será enviada por email.",
                            type: "warning",
                            html: true,
                            confirmButtonColor: "#000000",
                            showLoaderOnConfirm: true,
                            closeOnConfirm: true
                          }, function(isConfirm){    
                              if(isConfirm){   
      
                              }   
                         }); 
                    }
                });

                $('#id-text2').attr('class', 'grey');
                $('#id-company-text').attr('class', 'blue');
                $('#errolog').hide(); //Esconde o elemento com id errolog

                $('#formlogin').submit(function () { //Ao submeter formulário
                     var login = '';
                     var senha = '';
                     login = $('#usuario').val(); //Pega valor do campo email
                     senha = $('#senha').val(); //Pega valor do campo senha

                    //$('.loader').show();
                    if(login!='' && senha!=''){
                        $.ajax({ //Função AJAX
                            url: "config/redirecionar.php", //Arquivo php
                            type: "post", //Método de envio
                            data: "login=" + login + "&senha=" + senha, //Dados
                            success: function (result) { //Sucesso no AJAX
                                if (result == 1) {
                                    //alert('ok');
                                    location.href = '<?php echo $Config["Url"];   ?>' //Redireciona
                                }else{
                                    swal({    
                                        title: "",
                                        text: "<b>Usuário</b> ou <b>Senha</b> errados.",
                                        type: "error", 
                                        html: true,
                                        confirmButtonColor: "#000000",
                                        showLoaderOnConfirm: true,
                                        closeOnConfirm: true
                                      }, function(isConfirm){    
                                          if(isConfirm){   
                  
                                          }   
                                     });
                                   // $('.loader').hide();
                                  //  $('#errolog').show(); //Informa o erro
                                }
                            }
                        });
                    }else{
                        swal({   
                            title: "",
                            text: "Preencha o campos: <b>Usuário</b> e <b>Senha</b>.",
                            type: "warning",
                            html: true,
                            confirmButtonColor: "#000000",
                            showLoaderOnConfirm: true,
                            closeOnConfirm: true
                          }, function(isConfirm){    
                              if(isConfirm){   
      
                              }   
                         });
                    }
                    return false; //Evita que a página seja atualizada
                });
            });
        </script>
    </body>
</html>