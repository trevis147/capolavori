<?php
    include 'cabecalho.php';
    include "includes/funcoes/gerenciar.php";

    $load = 0;
    $user = '';
    if(isset($_GET[1]) && $_GET[1]!=''){

        $id = clean($_GET[1]);

        if(isset($_SESSION['id']) && (($_GET[1]==$_SESSION['id'])  || ($_SESSION['Nivel']==1))){
            $user_q = Query('SELECT * FROM usuario WHERE Usuario = '.$id.'');
            if(mysqli_num_rows($user_q) > 0){
                $user = mysqli_fetch_assoc($user_q);
                if($user['Nivel_usuario']!=0){
                    $nivel_usuario = $user['Nivel_usuario'];
                }
            }else{
                echo 0;
                exit;
            }
        }else{
            echo 0;
            exit;
        }
        
        $load = 1;
    }



?>



<div class="main-container" id="main-container">



    <?php include 'menu.php'; ?>



    <div class="main-content">

        <div class="main-content-inner">

            <div class="breadcrumbs" id="breadcrumbs">

                <ul class="breadcrumb">

                    <li>

                        <i class="ace-icon fa fa-home home-icon"></i>

                        <a href="<?php echo $Config['Url'];   ?>">Home</a>

                    </li>

                    <li>

                        <i class="ace-icon fa fa-picture-o home-icon"></i>

                        <a href="<?php echo $Config['Url'];  ?>usuarios">Usuário</a>

                    </li> 

                    <li class="active">Usuário</li>

                </ul>

            </div>



            <div class="page-content">

                <div class="row">

                    <div class="col-lg-12">

                        <h1 class="page-header">Usuário</h1>
                           
                    </div>
                    <?php  if($id!=0){  ?>
                        <a onclick="excluir_usuario();"  class="btn btn-danger" style="margin-bottom:15px; float:right; margin-right:2%;"> <i class="fa fa-trash-o"></i> Excluir </a> 
                    <?php  }  ?>
                </div>



                <div class="row">

                    <div class="col-lg-12">

                        <div class="panel panel-default">

                            <div class="panel-heading">

                                <i class="fa fa-arrow-down"></i> Cadastro

                            </div>

                            <div class="panel-body">
                        
           
                            <hr />

                            <form action="<?php echo $Config["Url"]; ?>gerenciar-usuario-query.php" method="POST"  id="FormRegistros">
                               <input name="Registro"  value="<?php echo $id;  ?>" type="hidden">
                                                                                           
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <span class="bigtext">Nome do usuário</span>
                                        </div>
                                        <div class="form-group">
                                            <input name="Titulo"  value="<?php echo isset($user['Titulo']) ? $user['Titulo'] : '';  ?>" maxlength="120" class="form-control req" type="text">
                                        </div>
                                </div>
                            
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <span class="bigtext">Email (Usado p/ login)</span>
                                        </div>
                                        <div class="form-group">
                                            <input name="Email"  value="<?php echo isset($user['Email']) ? $user['Email'] : '';  ?>" maxlength="120" class="form-control req" type="text">
                                        </div>
                                </div>

                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                    <div class="form-group">
                                        <span class="bigtext">Nível do usuário</span>
                                    </div>
                                    <div class="form-group">
                                        <div id="HtmlInpRegistro_mae" class="form-group">   
                                            <select name="Nivel">  
                                                <option value="0" <?php if($nivel_usuario==0){ echo 'selected'; }  ?>>Selecione</option>  
                                                <option value="1" <?php if($nivel_usuario==1){ echo 'selected'; }  ?>>Administrador</option>  
                                                <option value="2" <?php if($nivel_usuario==2){ echo 'selected'; }  ?>>Comum</option>  
                                            </select>
                                        </div>  
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <span class="bigtext">Senha</span>
                                        </div>
                                        <div class="form-group">
                                            <input name="Senha" value="" maxlength="120" class="form-control req" type="password">
                                        </div>
                                </div>
                                


                                <div class="units-row unit-centered unit-90 mb20" id="DivBtns"> 
                                    <div class="unit-30">&nbsp;</div>
                                        <div class="unit-70">
                                            <input value="Reset" class="btn unit-25" style="margin-left: 0;" type="reset">
                                            <input class="btn btn-primary" name="SisValCmpTipo" value="INSERT" readonly="" type="hidden">                   
                                            <input name="SisValCmpTabela" value="filho" readonly="" type="hidden">
                                            <input name="SisValCmpAcao" value="1" readonly="" type="hidden">
                                            <input value="Enviar formulário" class="btn btn-green unit-25" type="submit">
                                         </div>
                                </div>
        
                           
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
         <?php  if($id!=0){  ?>      
            function excluir_usuario(){
                    swal({   
                        title: "",
                        text: "Você tem certeza que deseja apagar o usuário selecionado ?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#ff0000",
                        showLoaderOnConfirm: true,
                        closeOnConfirm: true   
                        }, function(isConfirm){   
                        if(isConfirm){    
                            $.ajax({  
                                type: "POST",
                                async: false,
                                url: "<?php  echo $Config['Url'];   ?>dados/excluir_usuario.php",
                                data: "usuario=<?php  echo $id;   ?>",
                                success: function (retorno) {
                                    if(retorno==1){
                                      document.location = "<?php echo $Config['Url'];  ?>usuarios";
                                    }else if(retorno==0){
                                        swal({   
                                            title: "",
                                            text: "Problemas ao excluir o usuário.",
                                            type: "error",
                                            confirmButtonColor: "#ff0000",
                                            showLoaderOnConfirm: true,
                                            closeOnConfirm: true
                                          }, function(isConfirm){   
                                              if(isConfirm){   
                      
                                              }   
                                         }); 
                                    }else if(retorno==2){
                                        swal({   
                                            title: "",
                                            text: "Você não tem permissão para editar este usuário.",
                                            type: "error",
                                            confirmButtonColor: "#ff0000",
                                            showLoaderOnConfirm: true,
                                            closeOnConfirm: true
                                          }, function(isConfirm){   
                                              if(isConfirm){   
                      
                                              }   
                                         }); 

                                    }else if(retorno==3){
                                        swal({   
                                            title: "",
                                            text: "Usuário não identificado",
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
                        };        
                    }); 
            }
        <?php }   ?>

        $(function(){
            $('#FormRegistros').submit(function(){
                $.ajax({     
                    type: "POST",
                    async: false,
                    url: "<?php  echo $Config['Url'];   ?>/gerenciar-usuario-query.php",
                    data: $(this).serialize(),
                    success: function (retorno) {
                        if(retorno==0){
                            swal({   
                                title: "",
                                text: "Houveram erros no cadastro, verifique se preencheu todos os campos corretamente.",
                                type: "error",
                                confirmButtonColor: "#ff0000",
                                showLoaderOnConfirm: true,
                                closeOnConfirm: true
                              }, function(isConfirm){   
                                  if(isConfirm){    
          
                                  }   
                             }); 
                          //document.location = "<?php echo $Config['Url'];  ?>usuarios";
                        }else if(retorno==1){
                            swal({   
                                title: "",
                                text: "O usuário foi adicionado com sucesso",
                                type: "success",
                                confirmButtonColor: "#37b731",
                                showLoaderOnConfirm: true,
                                closeOnConfirm: true
                              }, function(isConfirm){   
                                  if(isConfirm){   
                                    document.location = "<?php echo $Config['Url'];  ?>usuarios";
                                  }   
                             });
                        }else if(retorno==2){
                            swal({   
                                title: "",
                                text: "Dados atualizados.",
                                type: "success",
                                confirmButtonColor: "#37b731",
                                showLoaderOnConfirm: true,
                                closeOnConfirm: true
                              }, function(isConfirm){   
                                  if(isConfirm){   
                                     document.location = "<?php echo $Config['Url'];  ?>usuarios";
                                  }   
                             });
                        }else if(retorno==3){
                            swal({   
                                title: "",
                                text: "O email informado já esta sendo usado.",
                                type: "warning",
                                confirmButtonColor: "#ff0000",
                                showLoaderOnConfirm: true,
                                closeOnConfirm: true
                              }, function(isConfirm){   
                                  if(isConfirm){   
          
                                  }   
                             });
                        }else if(retorno==4){
                            swal({   
                                title: "",
                                text: "Dados e senha atualizados.",
                                type: "success",
                                confirmButtonColor: "#37b731",
                                showLoaderOnConfirm: true,
                                closeOnConfirm: true
                              }, function(isConfirm){   
                                  if(isConfirm){   
                                     document.location = "<?php echo $Config['Url'];  ?>usuarios";
                                  }   
                             });
                        }
                    }
                }); 

                return false;
            });
        });
    </script>



    <?php include 'rodape.php' ?>