<?php include 'cabecalho.php';

$sql = 'Select * from menu_sistema where Titulo = "'.$_GET[1].'"';
$query = Query($sql,1);
$Titulo = $query['Rotulo'];
$tipo_pag = $query['Menu_sistema'];
$order_on = 0;

?>

<script>    
 
var checado = 0;

function selecionarTodos(){   
    if(checado==0){
        $('.check_delete').each(function(){
            $(this).prop("checked", true);
        });
        checado = 1;
    }else{
        $('.check_delete').each(function(){
            $(this).prop("checked", false);
        });
         checado = 0;
    }
}

function excluir_selecionados(){

    swal({   
        title: "",
        text: "Você tem certeza que deseja <b>excluir</b> os registros selecionados ? Registros vinculados serão <b>excluídos também</b>.",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#ff0000",
        showLoaderOnConfirm: true,
        html: true,
        closeOnConfirm: true   
        }, function(isConfirm){   
            if(isConfirm){      
                    $('.check_delete').each(function(){
        if($(this).prop("checked")){   

            elemento = $(this);

            $.ajax({  
                type: "POST",
                async: false, 
                url: "<?php  echo $Config['Url'];   ?>apagar.php",
                data: "Tabela=<?php echo $_GET[1];   ?>&Registro="+$(this).val()+"",
                success: function (retorno) {
                    if(retorno==1){
                      $(elemento).parents('tr').remove(); 
                    }else{
                        swal({   
                            title: "",
                            text: "Problemas ao excluir o usuário."+$(elemento).val(),
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


        }
    });   
        }
    });  
}
</script>


<style>
    .html5buttons{
        display: none;
    } 

    .search{
        float: left;
    }

    .main-content-inner { 
        padding-top: 14px !important;
    }
</style>

<div class="main-container" id="main-container">

    <?php include 'menu.php'; ?>


    <div class="main-content">
        <div class="main-content-inner">
            <div class="row" style="margin-left: 15px;">
                <a href="<?php echo $Config["Url"]; ?>gerenciar.php?1=<?php echo $_GET["1"]; ?><?php if(isset($_GET[2]) && $_GET[2]!=''){  ?>&3=<?php echo $_GET[2];  } ?>" class="btn btn-primary  <?php echo $_GET["1"];   ?>" style="margin-bottom:15px;">Cadastrar novo <?php //echo ucfirst($_GET["1"]); 

                        echo $Titulo;

                        ?></a>

                <a href="<?php echo $Config["Url"]; ?>exportar.php?1=<?php echo $_GET["1"]; ?><?php if(isset($_GET[2]) && $_GET[2]!=''){  ?>&3=<?php echo $_GET[2];  } ?>" class="btn btn-primary  <?php echo $_GET["1"];   ?>" style="margin-bottom:15px;">Exportar</a>   
        
                <a onclick="excluir_selecionados();"  class="btn btn-danger" style="margin-bottom:15px;"> <i class="fa fa-trash-o"></i> Excluir </a>   
            

            </div>  





                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" id="Registros_icon">
                               Exibindo registros da categoria <b><?php echo str_replace('_',' ',$_GET[1]);   ?></b> <a style="cursor:pointer;" data-toggle="tooltip" data-placement="top" data-original-title="Caso queira editar um registro, clique em EDITAR no canto direito."><i class="fa fa-info-circle"></i></a>
                            </div>
                            <div class="panel-body">
                                <div class="dataTable_wrapper">

                                                        <?php 



                        if(array_key_exists($_GET["1"], $Gerenciamentos)) {



                            
                            


                            $Colunas = array(ucfirst(strtolower($_GET["1"])));



                            



                            if(array_key_exists($_GET["1"], $Configuracoes["Tabela"])) {



                                                                



                                $ConPr2 = $Configuracoes["Tabela"][$_GET["1"]][2];



                                



                                if(isset($ConPr2) && $ConPr2 != "") {



                                    if(is_array($ConPr2)) {



                                        foreach($ConPr2 as $i => $v) {



                                            $Colunas[] = $v;    



                                        }



                                    } else {



                                        $Colunas[] = $ConPr2;



                                    }



                                } else {



                                    $Colunas[] = "Titulo";



                                }
        


                            } else {



                                $Colunas[] = "Titulo";



                            }


                            if($_GET[1]=='encomenda'){   
                                $Colunas[] = 'Qtd';
                                $Colunas[] = 'Cor';
                                $Colunas[] = 'ValorUn';
                                $Colunas[] = 'ValorTotal';
                                $Colunas[] = 'Acessorio';
                                
                            }


                           if($_GET[1]=='pesquisa'){   
                                $Colunas[] = 'Total_a';
                                $Colunas[] = 'Total_b';
                                $Colunas[] = 'Total_c';
                                $Colunas[] = 'Total_d';
                            }
                                


                            if($_GET[1]=='trabalhe_conosco'){

                                $Colunas[] = 'Arquivo';

                            }


                            if($_GET[1]=='certidao'){ 
                                $Colunas[] = 'Data_emissao';
                            }


                            if($_GET[1]=='pedido'){ 
                                //$Colunas[] = 'Revendedor';
                                $Colunas[] = 'Status_pedido';
                                //$Colunas[] = 'Empresa';
                            }

                            if($_GET[1]=='certificado'){
                                $Colunas[] = 'Mes';
                                $Colunas[] = 'Ano';
                            }    

                            /*if($_GET[1]=='denuncia'){
                                $Colunas[] = 'Data_entrada';
                                $Colunas[] = 'Gravidade_denuncia';
                            } */

                            if($_GET[1]=='log'){ 
                                $Colunas[] = 'Data';
                                $Colunas[] = 'Referencia';
                                $Colunas[] = 'Tipo';
                            }      

        

                            $New_array = $Colunas;

                            foreach($Gerenciamentos[$_GET[1]] as $n_v_3 => $v){

                                if($v[1]=='FLAG'){

                                    $New_array[] = $n_v_3;

                                }

                            }

                            if($_GET[1]!='encomenda'){
                                $New_array[] = 'Ativo';
                                $New_array[] = 'Destaque';
                            }   


                            if($_GET[1]=='deposito'){   
                                $Colunas[] = 'Quantidade';
                                $Colunas[] = 'Codigo';
                                $Colunas[] = 'Data_realizado';

                                $New_array[] = 'Quantidade'; 
                                $New_array[] = 'Codigo';
                                $New_array[] = 'Data_realizado';
                            }else if($_GET[1]=='troca'){         
                                //$Colunas[] = 'Quantidade';
                                $Colunas[] = 'Status_troca';
                                $Colunas[] = 'Pontos';
                                $Colunas[] = 'Data_solicitado';

                                //$New_array[] = 'Quantidade';
                                $New_array[] = 'Status_troca';
                                $New_array[] = 'Pontos';
                                $New_array[] = 'Data_solicitado'; 
                            } 



                            $Sql .= " Where ".$Where[0].'='.$Where[1].' ';







                                        $table = '';

                                        foreach($Gerenciamentos[$_GET[1]] as $n_v_3 => $v){

                                                if($v[1]=='KEY'){

                                                    $table = $v[2];

                                                    break;   

                                                } 

                                            }


                        if(isset($_GET[2]) && is_numeric($_GET[2])){



                            $Where = array(strtolower($table),$_GET[2]);

                            if($_GET[1]!='pedido'  && $_GET[1]!='certificado'){   
                                $TodosRegistros = Query(CriarQuerySimples("SELECT", $New_array, $_GET["1"], ucfirst(strtolower($_GET["1"]))." ASC",$Where));
                            }else if($_GET[1]=='certificado'){
                                $TodosRegistros = Query("SELECT * FROM certificado WHERE Ano = $_GET[4] AND Mes = $_GET[5] AND Cliente = $_GET[2] ORDER BY Certificado ASC");
                            }else{
                                $TodosRegistros = Query("SELECT * FROM pedido WHERE Ativo = 1 AND Revendedor = $_GET[2] ORDER BY Pedido,Titulo ASC");
                            }
                        }else{    
                            $TodosRegistros = Query("SELECT * FROM pedido WHERE Ativo = 1 ORDER BY Pedido,Titulo ASC");
                        }
 


                        if($_GET[1]=='solucao'){                   
                                $Colunas[] = 'Ordem'; 
                                $New_array[] = 'Ordem';
                                $order_on = 1;
                        }  


 
                
                            ?>


                                    <table id="dataTables-example" class="table table-striped table-bordered table-hover">



                                        <thead>
                                            <tr>
                                            <!--Seletor-->
                                                <th onclick="selecionarTodos()">#</th>
    
                                            <!--Titulo-->
                                            <?php

                                                foreach($Colunas as $i => $v) {

                                            ?>
                                                <th><?php echo Nomes($v);  ?></th>                                            

                                            <?php   
                                                    }
                                            ?>


                                            <?php foreach($Gerenciamentos[$_GET[1]] as $n_v_3 => $v){

                                                if($v[1]=='KID'){

                                            ?>
                                                <th><?php echo ucfirst($v[2]); ?></th>                                            
                                            <?php   
                                                }else{                        
                                                    if($v[4]=='FLAG'){
                                                        echo '<th>'.$n_v_3.'</th>';
                                                    }  
                                                }
                                            }
                                            ?>

                                                <?php /*foreach($Gerenciamentos[$_GET[1]] as $n_v_3 => $v){
                                                     
                                                    if($v[4]=='FLAG'){

                                                        echo '<th>'.$n_v_3.'</th>';

                                                        } 
                                                    } */
                                                ?>

                                                <th class="<?php  echo 'destaque_'.$_GET[1];  ?>">Destaque</th>

                                                <th>Ativo</th>

                                                <th>Editar</th>  
                                           

   
                                            </tr>

                                        </thead>

                                        <tbody   <?php /*  if($order_on){  ?> id="sortable" <?php } */  ?>   >
 
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                    <?php

                        } else {
                            ErroMsg("Este tipo de registro que você está tentando acessar não existe.");    
                        }

                    ?>
            </div>
        </div>
    </div>


<link href="<?php echo $Config['UrlSite'];  ?>sistema/css/dataTables/datatables.min.css" rel="stylesheet">
<script src="<?php echo $Config['UrlSite'];  ?>sistema/js/libs/dataTables/datatables.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/numeral.js/1.4.5/numeral.min.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>


<script>                      


        $(document).ready(function(){


            $('#sortable').sortable({
                start: function(event, ui) {
                   // alert('start'); 
                    var start_pos = ui.item.index();
                    ui.item.data('start_pos', start_pos);
                },
                change: function(event, ui) {
                 //   alert('change');
                    var start_pos = ui.item.data('start_pos');
                    var index = ui.placeholder.index();
                    if (start_pos < index) {
                        $('#sortable li:nth-child(' + index + ')').addClass('highlights');
                    } else {
                        $('#sortable li:eq(' + (index + 1) + ')').addClass('highlights');
                    }
                },
                update: function(event, ui) {
                   
                    $('#sortable li').removeClass('highlights');

                        var tr = '';
                        var pag = $(this).attr('id');



                        $('.ui-sortable-handle').each(function () {
                            tr = tr + $(this).attr('id').replace('tr', '') + ',';
                        });

                         //alert('pag = '+pag);
                        //alert('tr = '+tr);

                        $.ajax({
                            type: "POST",
                            url: "dados/atualiza_ordem.php",
                            data: "var=" + tr + "&pag=<?php echo $_GET[1];    ?>",
                            success: function (retorno) {
                                alert('Ordem atualizada!');
                                location.reload();
                            }
                        });

            
                }
            });



        $('#dataTables-example').DataTable( {
                "processing": true,
                "serverSide": true,
                "columns": [
                    { "data": "checkbox" },
                     <?php
                        foreach($Colunas as $i => $v) {
                    ?>
                        { "data": "<?php echo strtolower($v);  ?>" },
                    <?php   
                        }
                    ?>

                    <?php foreach($Gerenciamentos[$_GET[1]] as $n_v_3 => $v){

                        if($v[1]=='KID'){

                    ?>
                        { "data": "<?php echo strtolower($n_v_3); ?>" },  
                                                           
                    <?php   
                        }else if($v[4]=='FLAG'){ 
                    ?>
                        { "data": "<?php echo strtolower($n_v_3); ?>" },  
                    <?php
                            } 
                        }
                    ?>
                    { "data": "destaque" },
                    { "data": "ativo" },
                    { "data": "editar" }
                ],
                "ajax": '<?php  echo $Config['Url'];  ?>get-registros.php?1=<?php echo $_GET[1]    ?>&2=<?php echo $_GET[2];   ?>',
                "oLanguage": {
                "sProcessing":   "Processando...",
                "sLengthMenu":   "Mostrar _MENU_ registros",
                "sZeroRecords":  "Não foram encontrados resultados",
                "sInfo":         "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                "sInfoEmpty":    "Mostrando de 0 até 0 de 0 registros",
                "sInfoFiltered": "",
                "sInfoPostFix":  "",
                "sSearch":       "Buscar:",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "Primeiro",
                    "sPrevious": "Anterior",
                    "sNext":     "Seguinte",
                    "sLast":     "Último"
                    } 
                },
                <?php  if($order_on){    ?>    
                    "order": [[4,'asc']],
                <?php   }   ?>
                "iDisplayLength": 10,
                "columnDefs": [
                    { "orderable": false, "targets": 0 }
                  ],
                "aLengthMenu": [[10,20,40,80], [10,20,40,80]],
                "drawCallback": function(settings, json) {   

                $('.at').click(function () {            
                   
                    
        var id = $(this).attr("id").replace('a_', '');

        $.ajax({

            type: "POST",

            url: "<?php  echo $Config['Url'];  ?>config/ativar.php",

            data: "var=" + id + "&tabela=<?php  echo $_GET["1"];   ?>",

            success: function (retorno) {

                if (retorno == 1) {  
                    
                    $('#a_' + id).attr('src','<?php  echo $Config['Url'];  ?>img/ativar_24.png');

                } else if (retorno == 2) {
                   
                    $('#a_' + id).attr('src','<?php  echo $Config['Url'];  ?>img/desativar_24.png');

                } else {

                    alert("Erro pagina não foi ativa");

                }   

            }

        });

    });

 $('.des').click(function () {

        var id = $(this).attr("id").replace('d_', '');

        $.ajax({

            type: "POST",

            url: "<?php  echo $Config['Url'];  ?>config/destaque.php",

            data: "var=" + id + "&tabela=<?php  echo $_GET["1"];   ?>",

            success: function (retorno) {

                if (retorno == 1) {

                   $('#d_' + id).attr('src','<?php  echo $Config['Url'];  ?>img/ativar_24.png');

                } else if (retorno == 2) {

                   $('#d_' + id).attr('src','<?php  echo $Config['Url'];  ?>img/desativar_24.png');

                } else {

                    alert("Erro pagina não foi ativa");

                }

            }

        });

    });



   


      }

            });


        });
    </script>

<?php include 'rodape.php' ?>