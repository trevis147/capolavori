<?php
include 'header/cabecalho.php';
$tipo_pag = 5;

$sql_pagina = $db->select("agenda", "Agenda = '" . $_GET['Id'] . "'");
$pagina = mysql_fetch_assoc($sql_pagina);



$_SESSION['TipoPagina'] = $tipo_pag;
$_SESSION['Pagina'] = $_GET['Id'];

$_SESSION['Pag'] = 'agenda';

if(($pagina['Data'] != '0000-00-00') && ($pagina['Data'] != '')) {
    $d = explode('-', $pagina['Data']);
    $data = $d[2].'/'.$d[1].'/'.$d[0];
}



?>

<script>
$(document).ready(function() {
	$(".deletar").confirm({
		title:"Confirmação para apagar.",
		text:"Você tem certeza que deseja deletar isso?",
		confirm: function(button) {
			$.ajax({
                type: "POST",
                url: "dados/agenda.php",
                data: $('#form').serialize()+"&Deletar=deleta",
                success: function (retorno) {
					alert("Deletado com sucesso!");
					parent.location = "agenda.php";
                }
            });
		},
		cancel: function(button) {
			return false;
		},
		confirmButton: "Sim",
		cancelButton: "Não"
	});
});
</script>

<div class="main-container" id="main-container">

    <?php include 'menu/menu.php'; ?>

    <div class="main-content">
        <div class="main-content-inner">
            <div class="breadcrumbs" id="breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <i class="ace-icon fa fa-home home-icon"></i>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <i class="ace-icon fa fa-file-o home-icon"></i>
                        <a href="agenda.php">Agenda</a>
                    </li>
                    <li class="active">Agenda cadastro</li>
                </ul>
            </div>

            <div class="page-content">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Agenda</h1>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-arrow-down"></i> Cadastro de agenda<a style="cursor:pointer;" data-toggle="tooltip" data-placement="top" data-original-title="Cadastro da sua pagina na web."><i class="fa fa-info-circle"></i></a>
                            </div>

                            <div class="panel-body">
                                <form action="dados/agenda.php" method="post" enctype="multipart/form-data" id="form">
                                    <input type="hidden" name="Id" value="<?php echo $_GET['Id'] ?>" />
                                    
                                    <div class="form-group">
                                        <label>Titulo</label>
                                        <input type="text" class="form-control" placeholder="Titulo" name="Titulo" value="<?php echo $pagina['Titulo'] ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label>Data</label>
                                        <input type="text" class="form-control datepicker" placeholder="Data" name="Data" value="<?php echo $data; ?>">
                                    </div>

                                    <div class="form-group">
                                        <label>Hora</label>
                                        <input type="text" class="form-control" placeholder="Hora" name="Hora" value="<?php echo $pagina['Hora'] ?>" required>
                                    </div>


                                    <label for="inputEmail3" class="col-sm-2 control-label">Compartilhar com os usuários</label>
                                        <div class="form-group" style="padding-left:20%;">
                                            <select multiple="multiple" id="my-select" name="Login[]">
                                            <?php         

                                                $ids = array();

                                                    if(isset($_GET['Id'])){

                                                        $sql_sistemas = 'Select Login from login_agenda where Agenda ='.$_GET['Id'].'';
                                                        $res_sis = mysql_query($sql_sistemas);
                            
                                                        while($resp_sis = mysql_fetch_assoc($res_sis)){
                                                            array_push($ids,$resp_sis['Login']);
                                                        }

                                                }

                                         $sql = 'Select Login,Nome from login order by(Nome)';
                                         $result = mysql_query($sql);

                                         $i = 0;
                                         while($res = mysql_fetch_assoc($result)){
                                        ?>
                                            <option value='<?php echo $res['Login'];   ?>'  <?php if(in_array($res['Login'],$ids)){echo 'selected';}  ?>><?php echo $res['Nome'];   ?></option>
                                        <?php  $i++;  } ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <select name="Cliente" class="form-control">
                                            <option value="0">Selecione o cliente</option>
                                        <?php        
                                            $query = mysql_query("Select * from cliente where Status = 1");
                                            while($result = mysql_fetch_assoc($query)){
                                                ?> 
                                            <option value="<?php echo $result['Cliente'];    ?>"   <?php if($result['Cliente']==$pagina['Empresa']){ echo 'selected';} ?>><?php echo $result['Titulo'];    ?></option>
                                        <?php  }   ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label>Contato</label>
                                        <input type="text" class="form-control" placeholder="Contato" name="Contato" value="<?php echo $pagina['Contato'] ?>" required>
                                    </div>


                                    <div class="form-group">
                                        <select name="Assunto" class="form-control">
                                            <option value="0">Selecione o assunto</option>
                                        <?php        
                                            $query = mysql_query("Select * from assunto_reuniao");  
                                            while($result = mysql_fetch_assoc($query)){
                                                ?>
                                            <option value="<?php echo $result['Assunto_reuniao'];    ?>"   <?php if($result['Assunto_reuniao']==$pagina['Assunto']){ echo 'selected';} ?>><?php echo $result['Titulo'];    ?></option>
                                        <?php  }   ?>
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label>Local</label>
                                        <textarea class="ckeditor" name="Local"><?php echo $pagina['Local'] ?></textarea>
                                    </div>

                            

              
                                    <div class="col-lg-10">
                                        <?php if (!isset($_GET['Id']) && $_GET['Id'] == '') { ?>
                                            <button type="submit" class="btn btn-primary"><i class="glyphicon glyphicon-floppy-save"></i> Inserir</button>
                                        <?php } else { ?>
                                            <button type="submit" class="btn btn-primary" name="Alterar"><i class="glyphicon glyphicon-refresh"></i> Alterar</button>
                                            <button type="submit" class="btn btn-danger deletar" name="Deletar"><i class="fa fa-trash"></i> Deletar</button>
                                        <?php } ?>
                                        <button type="button" class="btn btn-default" onClick="location.href = 'servicos.php'"><i class="fa fa-arrow-left"></i> Cancelar</button>
                                    </div>

                                </form>
                            </div>
                        </div>

                        <div class="col-lg-12" <?php if ($_GET['Id'] == '') { ?> style="display:none;" <?php } ?> id="abrir_galeria">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <i class="fa fa-arrow-down"></i> Galeria <a style="cursor:pointer;" data-toggle="tooltip" data-placement="top" data-original-title="Arraste suas fotos ou então seleciona suas fotos."><i class="fa fa-info-circle"></i></a>
                                	Especificação de imagem tamanho (900px por 600px)
								</div>

                                <div class="panel-body">
                                    <form action="dados/galerias_fotos.php" class="dropzone">
                                        <div class="fallback">
                                            <input name="file" type="file" multiple />
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    $('#my-select').multiSelect();
</script>
    <?php include 'rodape.php' ?>