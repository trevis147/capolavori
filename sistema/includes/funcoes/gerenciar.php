<?php

	function cria_select($tabela,$id,$param,$value){

		// echo 'tabela: '.$tabela.'<br>';
		// echo 'id: '.$id.'<br>';
		// echo 'param: '.$param.'<br>';
		// echo 'value: '.$value.'<br>';

		global $Config;


		if($tabela == 'ano'){
			$id = $_GET[4];
		}

		if($tabela == 'mes'){
			$id = $_GET[5];
		}

		if($tabela == 'pai'){
			$tabela = 'animal';
		}

		if($tabela == 'mae'){
			$tabela = 'animal';
		} 


 
		$corpo = '';
		//$corpo = '<option value="0">Selecione<option>';
		$query = '';

		$sql = '';
   
		if($param!=''  && $param!='NOT NULL'){
			$sql = 'Select * from '.$tabela.' where '.$param.' = "'.$value.'"';
			$query = Query($sql);  
		}else{
			$sql = 'Select * from '.$tabela.'';
			$query = Query($sql);	
		}
		
		//echo $sql;
		
		/*if($tabela == 'cliente'){   
			echo 'id = '.$id;
			exit; 
		}*/   


			while($result = mysqli_fetch_assoc($query)){
				if($result[ucfirst($tabela)]==$id){
					$corpo .= '<option value="'.$result[ucfirst($tabela)].'" selected>'.$result['Titulo'].'</option>';
				}else{
					$corpo .= '<option value="'.$result[ucfirst($tabela)].'">'.$result['Titulo'].'</option>';
				}

			}

		return $corpo;
	}


	function CarregarModulos($Modulos) {
		
		global $Config;
		
		if(is_array($Modulos)) {
			if(count($Modulos) > 0) {
				
				foreach($Modulos as $i => $v) { 
					
					switch(strtoupper($i)) {
						
						case "CKEDITOR":	
							?>
								<script type="text/javascript" src="<?php  echo $Config['Url'];   ?>ckeditor/ckeditor.js"></script>
                            <?php
						break;
					}
						
				}
				
			}
		}
	}
	
	function CriarBotaoSubmitForm($Acao, $DadosValidos) {
	
		global $Config;
		
		?>
        <div class="units-row unit-centered unit-90 mb20" id="DivBtns">
            	<?php
					if($DadosValidos == 0) {
						?>
                        <input type="button" value="Voltar" id="BtnVoltar" class="btn btn-red unit-20" />
                        <?php
					} else {
				?>
                <div class="unit-30">&nbsp;
                </div>
                <div class="unit-70">
                    <input type="reset" value="Reset" class="btn unit-25" style="margin-left: 0;" />
                    <?php
                    if($Acao == 1) {
                        ?>
                         <input type="hidden" class="btn btn-primary" name="<?php echo $Config["PrefixoControle"]; ?>Tipo" value="INSERT" readonly />                   
                        <?php
                    } else {
                        ?>
                        <input type="button" id="BtnApagar" value="Apagar registro" class="btn btn-red unit-25" />
                        <input type="hidden" name="<?php echo $Config["PrefixoControle"]; ?>Registro" value="<?php echo ((isset($_GET[2]) && is_numeric($_GET[2]) && $_GET[2] > 0)?$_GET[2]:0); ?>" readonly />
                        <input type="hidden" name="<?php echo $Config["PrefixoControle"]; ?>Tipo" value="UPDATE" readonly />
                        <?php
                    }
                    ?>
                    <input type="hidden" name="<?php echo $Config["PrefixoControle"]; ?>Tabela" value="<?php echo strtolower((isset($_GET[1]) && $_GET[1] != "")?$_GET[1]:""); ?>" readonly />
                    <input type="hidden" name="<?php echo $Config["PrefixoControle"]; ?>Acao" value="<?php echo $Acao; ?>" readonly />
                    <input type="submit" value="Enviar formulário" class="btn btn-green unit-25" />
                 </div>
                <?php } ?>
        </div>
        <?php
		
		if($Acao == 2) {
			?>
            <div class="units-row unit-centered unit-90 mb20" id="ContentApagarConfirm" style="display: none;">
                    <div class="unit-30">&nbsp;
                    </div>
                    <div class="unit-70">
                    	<p>Você tem certeza de que gostaria de remover este registro? <strong>Esta ação não poderá ser desfeita.</strong></p>
                        <p>
                        	<input type="button" id="BtnApagarNao" value="Não" class="btn btn-red unit-20" />
                            <input type="button" id="BtnApagarSim" value="Sim" class="btn btn-green unit-20" />
                        </p>
                    </div>    
            </div>
            <script>
				$(document).ready(function() {
					$("#BtnApagar").click(function() {
						$("#DivBtns").slideUp();
						$("#ContentApagarConfirm").slideDown();
					});
					$("#BtnApagarNao").click(function() {
						$("#DivBtns").slideDown();
						$("#ContentApagarConfirm").slideUp();
					});
					$("#BtnApagarSim").click(function() {
						
						$(".page-content").slideUp(200, function() {
							$(".page-content").html('Apagando...').slideDown();
							var Dados = "Registro=<?php echo ((isset($_GET[2]) && is_numeric($_GET[2]) && $_GET[2] > 0)?$_GET[2]:0); ?>&Tabela=<?php echo strtolower((isset($_GET[1]) && $_GET[1] != "")?$_GET[1]:""); ?>";
							$.ajax({
								type: "POST",
								url: '<?php echo $Config["Url"]; ?>apagar.php',
								data: Dados,
								success: function(data){
									var ContentHtml = '<p>Este registro foi removido com sucesso. Você será redirecionado após <b id="Contador">10</b> segundos. </p> <p> <input type="button" id="BtnApagarNao" value="Voltar à lista de registros" class="btn unit-20" onclick="window.location = \'<?php echo $Config["Url"]; ?>registros.php?1=<?php echo strtolower((isset($_GET[1]) && $_GET[1] != "")?$_GET[1]:""); ?>&2=<?php echo strtolower((isset($_GET[3]) && $_GET[3] != "")?$_GET[3]:""); ?>\'" /> </p>';
									$('.page-content').html(ContentHtml).slideDown();
									
									setTimeout(function() {
										  window.location = '<?php echo $Config["Url"]; ?>registros.php?1=<?php echo strtolower((isset($_GET[1]) && $_GET[1] != "")?$_GET[1]:""); ?>&2=<?php echo strtolower((isset($_GET[3]) && $_GET[3] != "")?$_GET[3]:""); ?>';
									}, 10000);
									
									(function(){
										var C = parseInt($("b#Contador").html())-1;
										$("b#Contador").html(C);
										setTimeout(arguments.callee, 1000);
									})();
									
								}
							});
						});
					});
				});
			</script>
            <?php	
		}
			
	}
	
	function CriarComponente($i, $v, $Dados,$Value) {
		global $Ckeditor_include_on;
		global $Config;
		$Modulos = array();
		
		$d = 0; 
		if($Dados != NULL) {
			$d = 1;	
		}
		
		$value =  explode('_',$i);
		if($value[0]!='L'    && $v[1]!='FLAG' && $v[1]!='MULTIPLE_IN'){

	?>
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <div class="form-group">
	            <span class="bigtext"><?php 
	            //&& $v[1]!='KEY'
	            	
					if($v[0] != -1) {	
						if($v[0] == NULL) { 
							if(Nomes($i)!='Galeria'){
								echo Nomes($i);
							}
						} else { 
							if( $v[0]!='Galeria'){
								echo $v[0];
							}
						}
					} else {
						if($i!='Galeria'){
							echo $i;
						}
					}

			
				?></span>
            </div>
            <div class="form-group">
				<?php
					switch(strtoupper($v[1])) {
						

   
						case "VARCHAR":
							?>    
							<?php if($_GET[1]=='denuncia'){     ?>
                            	<input name="<?php echo $i; ?>" id="HtmlInp<?php echo $i; ?>" value="<?php echo (($d == 0)?"":$Dados[$i]); ?>" type="<?php echo ((isset($v[4]) && $v[4] != NULL)?$v[4]:"text"); ?>" maxlength="<?php echo $v[2]; ?>" class="form-control <?php echo ((isset($v[3]) && $v[3] == "NOT NULL")?"req":""); ?>" readonly />
                                <?php echo ((isset($v[5]) && $v[5] != NULL)?'<br /><span class="label">'.$v[5].'</span>':""); ?>
                            <?php }else{    ?>
								 <input name="<?php echo $i; ?>" id="HtmlInp<?php echo $i; ?>" value="<?php echo (($d == 0)?"":$Dados[$i]); ?>" type="<?php echo ((isset($v[4]) && $v[4] != NULL)?$v[4]:"text"); ?>" maxlength="<?php echo $v[2]; ?>" class="form-control <?php echo ((isset($v[3]) && $v[3] == "NOT NULL")?"req":""); ?>" />
                                <?php echo ((isset($v[5]) && $v[5] != NULL)?'<br /><span class="label">'.$v[5].'</span>':""); ?>
                            <?php }   ?>
                            <?php
						break;

						case "DATE":

							if(($Dados[$i] != '0000-00-00') && ($Dados[$i] != '')) {
    							$d = explode('-', $Dados[$i]);
    							$data = $d[2].'/'.$d[1].'/'.$d[0];
							}							?>

							<?php if($_GET[1]=='denuncia'){     ?>   
                            	<input name="<?php echo $i; ?>" id="HtmlInp<?php echo $i; ?>" value="<?php echo $data; ?>" type="text"  class="form-control datepicker" readonly/>
                                <?php echo ((isset($v[5]) && $v[5] != NULL)?'<br /><span class="label">'.$v[5].'</span>':""); ?>
							<?php   }else{      ?>
								<input name="<?php echo $i; ?>" id="HtmlInp<?php echo $i; ?>" value="<?php echo $data; ?>" type="text"  class="form-control datepicker" />
                                <?php echo ((isset($v[5]) && $v[5] != NULL)?'<br /><span class="label">'.$v[5].'</span>':""); ?>
							<?php   }  	?>


                            <?php
						break;

						
						case "CHECK":
							?>
                            	<input type="checkbox" id="HtmlInp<?php echo $i; ?>" value="1"  name="<?php echo $i; ?>"<?php echo (($Dados[$i] == 1)?' checked="checked"':''); ?>  />
                                <?php echo ((isset($v[5]) && $v[5] != NULL)?'<br /><span class="label">'.$v[5].'</span>':""); ?>
                            <?php
						break;
						
						case "MULTIPLE":
							?>
								<?php if($_GET[1]=='curso'){  ?>
								<input type="hidden" name="multiple_value<?php echo $i; ?>[]"  id="multiple_value<?php echo $i; ?>" style="display:none;"/>
                            	<select  multiple="multiple" name="<?php echo $i; ?>[]" id="HtmlInp<?php echo $i; ?>" class="form-control">
                                			
                                	<?php
                                		//se é multiple esta chave contem o nome de duas tabelas 
										$tabelas = explode('_',$v[2]);
										
										$t_fonte = '';
										$t_chave = '';

										if($v[2]=='relacionado_curso'){
											$t_fonte = 'curso';
											$t_chave = 'curso'; 
										}else{
											$t_fonte = $tabelas[0];  // nome da tabela que guarda o attr exe: tag
											$t_chave = $tabelas[1]; //nome da tabela que esta salvo o atual registro mostrado ex:Post
										}

										if($v[2]=='relacionado_curso'){
											$sql = 'SELECT Relacionado as Curso from relacionado_curso where Curso = '.$_GET[2].'';
										}else{
											$sql = 'SELECT '.ucfirst($t_fonte).' from '.$v[2].' where '.ucfirst($t_chave).' = '.$_GET[2].'';
										}
										
										
										//echo $sql;
										//exit;

										$query = Query($sql);

										$flag = 0;
										$query_aux = '';




										while($resp = mysqli_fetch_assoc($query)){
											$id =  $resp[ucfirst($t_fonte)];

											if($v[2]=='relacionado_curso'){
												$sql_fonte = "SELECT * from curso where Curso = ".$id." order by(Titulo) ASC";
											}else{
												$sql_fonte = "SELECT * from ".$t_fonte." where ".ucfirst($t_fonte)." = ".$id." order by(Titulo) ASC";
											}
										
											


											$q_fonte = Query($sql_fonte);
											$fonte = mysqli_fetch_assoc($q_fonte);

											$titulo = $fonte['Titulo'];
											$id = $fonte[ucfirst($t_fonte)];

											if($flag==0){
												$query_aux .= " ".ucfirst($t_fonte)." <> ".$id." ";
												$flag=1;
											}else{
												$query_aux .= " AND ".ucfirst($t_fonte)." <> ".$id." ";
											}
											
											if($v[2]=='relacionado_curso'){
												if($trava==0){
													$multiple_valueRelacionado .= $id;	
													$trava=1;
												}else{
													$multiple_valueRelacionado .= ', '.$id;	
												}
											}
											
   
											echo '<option value="'.$id.'" selected>'.$titulo.'</option>';


										}
										echo '<script>document.getElementById("multiple_valueRelacionado").value="'.$multiple_valueRelacionado.'";</script>';

										$plus = '';

										if(!is_numeric($v[3]) && ($v[3]!='')){
											$plus .= ''.ucfirst($v[3]).'='.$_GET[3]; 
										}else{
											
										}


										if($query_aux!=''){
											
											if($v[2]=='relacionado_curso'){
												if($plus!=''){
													$sql_final =  "SELECT * from ".$t_fonte." where ".$query_aux." AND ".$plus." order by(Titulo) ASC";
												}else{
											    	$sql_final =  "SELECT * from ".$t_fonte." where ".$query_aux." order by(Titulo) ASC";
													
												}
											}else{
												if($plus!=''){
													$sql_final =  "SELECT * from ".$t_fonte." where ".$query_aux." AND ".$plus." order by(Titulo) ASC";
												}else{
											    	$sql_final =  "SELECT * from ".$t_fonte." where ".$query_aux." order by(Titulo) ASC";
												}
											}
  

				
											
										}else{

											if($plus!=''){
												$sql_final =  "SELECT * from ".$t_fonte." WHERE ".$plus." order by(Titulo) ASC";
											}else{
												$sql_final =  "SELECT * from ".$t_fonte." order by(Titulo) ASC";
											}
											
										}

										//echo $sql_final;   
										//exit;

										
										$q_final = Query($sql_final);

										while($r_f = mysqli_fetch_assoc($q_final)){

											$titulo = $r_f['Titulo'];
											$id = $r_f[ucfirst($t_fonte)];

											echo '<option value="'.$id.'">'.$titulo.'</option>';
										}
 

									?> 
                                </select>
                                <?php }else{    ?>
                                   <input type="hidden" name="multiple_value<?php echo $i; ?>[]" id="multiple_value<?php echo $i; ?>" style="display:none;"/>
                                   <select  multiple="multiple" name="<?php echo $i; ?>[]" id="HtmlInp<?php echo $i; ?>" class="form-control">
                                	  
                                	<?php
                                		//se é multiple esta chave contem o nome de duas tabelas 
										$tabelas = explode('_',$v[2]);
										$t_fonte = $tabelas[0];  // nome da tabela que guarda o attr exe: tag
										$t_chave = $tabelas[1]; //nome da tabela que esta salvo o atual registro mostrado ex:Post




										$sql = 'SELECT `'.ucfirst($t_fonte).'` from `'.$v[2].'` where `'.ucfirst($t_chave).'` = '.$_GET[2].'';
										
										//echo $sql;
										//exit; 

										$query = Query($sql);

										$flag = 0;
										$query_aux = '';




										while($resp = mysqli_fetch_assoc($query)){
											$id =  $resp[ucfirst($t_fonte)];

											$sql_fonte = "SELECT * from `".$t_fonte."` where `".ucfirst($t_fonte)."` = ".$id." order by(Titulo) ASC";



											$q_fonte = Query($sql_fonte);
											$fonte = mysqli_fetch_assoc($q_fonte);

											$titulo = $fonte['Titulo'];   
											$id = $fonte[ucfirst($t_fonte)];

											if($flag==0){
												$query_aux .= " `".ucfirst($t_fonte)."` <> ".$id." ";
												$flag=1;
											}else{
												$query_aux .= " AND `".ucfirst($t_fonte)."` <> ".$id." ";
											}
										
											echo '<option value="'.$id.'" selected>'.$titulo.'</option>';


										}  


										$plus = '';

										if(!is_numeric($v[3]) && ($v[3]!='')){
											$plus .= '`'.ucfirst($v[3]).'`='.$_GET[3]; 
										}else{
											
										}


										if($query_aux!=''){
											
											if($plus!=''){
												$sql_final =  "SELECT * from `".$t_fonte."` where ".$query_aux." AND ".$plus." order by(Titulo) ASC";
											}else{
											    $sql_final =  "SELECT * from `".$t_fonte."` where ".$query_aux." order by(Titulo) ASC";
											}
											
										}else{

											if($plus!=''){
												$sql_final =  "SELECT * from `".$t_fonte."` WHERE ".$plus." order by(Titulo) ASC";
											}else{
												$sql_final =  "SELECT * from `".$t_fonte."` order by(Titulo) ASC";
											}
											
										}
										//echo $query_aux;
										//echo $sql_final;
										//exit;

										
										$q_final = Query($sql_final);   

										while($r_f = mysqli_fetch_assoc($q_final)){

											$titulo = $r_f['Titulo'];
											$id = $r_f[ucfirst($t_fonte)];

											echo '<option value="'.$id.'">'.$titulo.'</option>';
										}


									?>
                                </select>
                                <?php }  ?>

                                <script>  
									//$('#HtmlInp<?php echo $i; ?>').multiSelect({ keepOrder: true });
									$(function(){
        								$('#HtmlInp<?php echo $i; ?>').multiSelect({
          									afterSelect: function(value, text){
            								var get_val = $("#multiple_value<?php echo $i; ?>").val();
            								var hidden_val = (get_val != "") ? get_val+"," : get_val;
            								$("#multiple_value<?php echo $i; ?>").val(hidden_val+""+value);
          								},
          									afterDeselect: function(value, text){
            								var get_val = $("#multiple_value<?php echo $i; ?>").val();
            								var new_val = get_val.replace(value, "");
            								$("#multiple_value<?php echo $i; ?>").val(new_val);
         								 }
        								});
    								}); 
								</script>
                                <?php echo ((isset($v[5]) && $v[5] != NULL)?'<br /><span class="label">'.$v[5].'</span>':""); ?>
                            <?php
						break;
						
						case "FLOAT":
						case "INT":
							?>
                            	<input name="<?php echo $i; ?>" id="HtmlInp<?php echo $i; ?>" class="form-control" value="<?php echo (($d == 0)?"":$Dados[$i]); ?>" type="<?php echo ((isset($v[4]) && $v[4] != NULL)?$v[4]:"text"); ?>" maxlength="<?php echo (($v[2] != NULL)?$v[2]:10); ?>" class="width-100 <?php echo ((isset($v[3]) && $v[3] == "NOT NULL")?"req":""); ?>" />
                                <?php echo ((isset($v[5]) && $v[5] != NULL)?'<br /><span class="label">'.$v[5].'</span>':""); ?>
                            <?php
						break;
						case "KID":
							return false;
						break;
						case "KEY":
							if(!is_numeric($v[2])){
								$chave =  $v[2];

							}

							$table = strtolower($i);
   
							//echo '1 = '.$table;
							//echo '2  = '.$Dados[$i];
							//echo '3  = '.$chave;
							//echo '4 = '.$Value;  
								
					   ?>
							<div id="HtmlInp<?php echo $i; ?>" class="form-group">	
								<select name="HtmlInp<?php echo $i; ?>"  disabled>
									<option value="0">Selecione</option>  
									<?php 
										if(isset($_GET[3]) && $_GET[3]!=''){
											echo cria_select($table,$_GET[3],ucfirst($table),$_GET[3]);  
										}else{
											echo cria_select($table,$Dados[$i]);  	
										}
										

									?>
								</select>
							</div>	
					<?php
							
						break;
						case "FLAG":
							return false;
						break;
						case "GALERIA";
							$_SESSION['GALERIA'] = 1;
						break;
						case "FILE";
						?>
							    <input class="DispFt" type="file" name="<?php echo $i; ?>" id="HtmlInp<?php echo $i; ?>" />
                                <input type="hidden" name="Local<?php echo $i; ?>[]" value="<?php echo $v[2]; ?>" />
                                <?php
									foreach($v[4] as $ii => $vi) { 
										?>
                                        <input type="hidden" name="Tamanho<?php echo $i; ?>[]" value="<?php echo $vi[0].",".$vi[1]; ?>" />
                                        <?php	
									}
								?>

								<a target="_blank" href="<?php  echo $Config['UrlSite'];   ?>imagens/<?php  echo $_GET[1];   ?>/<?php echo (($d == 0)?"":$Dados[$i]); ?>">Arquivo</a>

								<?php if($d == 1) { ?> 
									<br>
                                    <label>
                                        <input type="checkbox" name="ApagarFoto<?php echo $i; ?>" id="ApagarFoto<?php echo $i; ?>" value="1">
                                        Remover arquivo deste registro
                                    </label> <br />
                                    <script>
										$(document).ready(function() {
                                            $("#ApagarFoto<?php echo $i; ?>").click(function() {
                                            	var Ch = $(this).is(":checked");
												if(Ch == true) {
													$(".DispFt").hide();
												} else {
													$(".DispFt").show();
												}
                                            });
                                        });
									</script>
                                <?php } ?>


                                <?php echo ((isset($v[3]) && $v[3] != NULL)?'<br /><span class="label DispFt">'.$v[3].'</span>':""); 



						break;
						case "IMAGEM":
							//print_r($v);
							?>
                            	<?php
									if($d == 1) {
										if($Dados[$i] != "") {
											?>
                                            <small class="DispFt">A imagem atual é:</small><br /><br />
                                            <?php
											
											$MenorTamanho = 0;
											foreach($v[4] as $ii => $vi) {
												if($MenorTamanho == 0) {
													$MenorTamanho = $vi[0];
												} elseif($vi[0] < $MenorTamanho) {
													$MenorTamanho = $vi[0];
												}
											}
											?>
                                            <img src="<?php echo $Config["UrlSite"]; ?>imagens/<?php echo $v[2]; ?>/<?php echo $MenorTamanho; ?>/<?php echo $Dados[$i]; ?>" style="max-width:100%; height:auto;" /><br /><br />
                                            <?php
											
										}
									}
								?>
                                
                                <?php if($d == 1) { ?>
                                    <label>
                                        <input type="checkbox" name="ApagarFoto<?php echo $i; ?>" id="ApagarFoto<?php echo $i; ?>" value="1">
                                        Remover foto deste registro
                                    </label> <br />
                                    <script>
										$(document).ready(function() {
                                            $("#ApagarFoto<?php echo $i; ?>").click(function() {
                                            	var Ch = $(this).is(":checked");
												if(Ch == true) {
													$(".DispFt").hide();
												} else {
													$(".DispFt").show();
												}
                                            });
                                        });
									</script>
                                <?php } ?>
                                
                                <input class="DispFt" type="file" name="<?php echo $i; ?>" id="HtmlInp<?php echo $i; ?>" />
                                <input type="hidden" name="Local<?php echo $i; ?>[]" value="<?php echo $v[2]; ?>" />
                                <?php
									foreach($v[4] as $ii => $vi) {
										?>
                                        <input type="hidden" name="Tamanho<?php echo $i; ?>[]" value="<?php echo $vi[0].",".$vi[1]; ?>" />
                                        <?php	
									}
								?>
                                <?php echo ((isset($v[3]) && $v[3] != NULL)?'<br /><span class="label DispFt">'.$v[3].'</span>':""); ?>
                            <?php
						break;
						
						case "TEXT":
							?>
							<?php if($_GET[1]=='denuncia'){     ?>
								<div id="HtmlInp<?php echo $i; ?>" class="form-group">	
								<textarea disabled id="HtmlInp<?php echo $i; ?>" class="ckeditor" placeholder="Texto" name="HtmlInp<?php echo $i; ?>"><?php echo Texto((($d == 0)?"":$Dados[$i]), "Ler"); ?></textarea></div>
							<?php   }else{     ?>
								<div id="HtmlInp<?php echo $i; ?>" class="form-group">	
								<textarea  id="HtmlInp<?php echo $i; ?>" class="ckeditor" placeholder="Texto" name="HtmlInp<?php echo $i; ?>"><?php echo Texto((($d == 0)?"":$Dados[$i]), "Ler"); ?></textarea></div>
							<?php   }  ?>


                            <?php
                            	$Ckeditor_include_on = 1;
								if(isset($v[2]) && $v[2] == 1) {
									$Modulos["CKEDITOR"] = 1;
									?>
			
									<?php
								}
						break;

						case "RESUMO":
							?>
								<div id="HtmlInp<?php echo $i; ?>" class="form-group">	
								<textarea id="HtmlInp<?php echo $i; ?>" maxlength="1500" style="margin: 0px; width: auto; height: 178px;" class="form-control custom-control"   placeholder="Resumo" name="HtmlInp<?php echo $i; ?>"><?php echo Texto((($d == 0)?"":$Dados[$i]), "Ler"); ?></textarea></div>
                            <?php
						break;
						
						default: 
							
							if(!is_numeric($v[2])){
								$chave =  $v[2];

							}

							

							$table = strtolower($i);
							?>
							<div id="HtmlInp<?php echo $i; ?>" class="form-group">	
								<select name="HtmlInp<?php echo $i; ?>">
									<option value="0">Selecione</option>
									<?php echo cria_select($table,$Dados[$i],$chave,$Value);   ?>
								</select>
							</div>

						
					<?php
						//print_r($v);
						//echo "<strong>O tipo ".$v[1]." não está definido!</strong>";
						break;
						
					}
				?>
            </div>
        </div>
        <?php
		}

		//CarregarModulos($Modulos);
		
	}
?>