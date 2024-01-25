<?php 	//print_r($_POST);
		//exit;

		require_once("./config/config.php");
		include "includes/head.php";	

	session_start();
	if (!isset($_SESSION['Sis545IdUsuario'])) {
	    session_destroy();
	    header("Location: ".$Config['Url']."login.php");
	    exit;
	}



ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


	


	$prefixo = $Config['PrefixoControle'];	
	$Excluidos = array($Config["PrefixoControle"]."Tipo", $Config["PrefixoControle"]."Tabela", $Config["PrefixoControle"]."Acao",$Config["PrefixoControle"]. "Registro");

		function TratarTipoDado($Tipo = NULL, $Nome = NULL, $Valor = NULL, $Acao = 1, $ArrayAssocValores = NULL,$prefixo) {

			

			if($Tipo == NULL) { 
				return FALSE;	
			}

			$qTemp = "";
			$a = "'";

			switch($Tipo) {



				case "MULTIPLE_IN":
				return false;
				break;

				case "MULTIPLE":

				//print_r($_POST);
				//exit;

					if(isset($_POST[$prefixo."Registro"]) && $_POST[$prefixo."Registro"]!=''){

  						//print_r($_POST);
  						//exit;
						
						if(isset($_POST[$Nome][0]) && $_POST[$Nome][0]!=''){
						//if(isset($_POST['multiple_value'.$Nome][0]) && $_POST['multiple_value'.$Nome][0]!=''){
							$t_fonte = strtolower($Nome);
							$Fonte = ucfirst($t_fonte);
							$t_atual = strtolower($_POST[$prefixo."Tabela"]);
							$Id = ucfirst($t_atual);
							$table = $t_fonte.'_'.$t_atual;
							$sql = "delete from `".$table."` WHERE `".ucfirst(strtolower($_POST[$prefixo."Tabela"]))."`=".$_POST[$prefixo."Registro"]."";

							//echo $sql;
							//exit;
							Query($sql);


							//echo $_POST[$Nome][0];
							//print_r($_POST[$Nome]);
							//exit;

							$array_values = array();
							//$array_values = explode(',',$_POST[$Nome][0]);
							
							//print_r($array_values);
							//exit;

							if(is_array($_POST[$Nome])){
								foreach($_POST[$Nome] as $key => $value) {  
									$sql_insert = 'Insert into `'.$table.'`(`'.$Fonte.'`,`'.$Id.'`) values ('.$value.','.$_POST[$prefixo."Registro"].')';

								//	echo $sql_insert;
									Query($sql_insert);
									//echo $sql_insert;
								}   
								//exit;  
							}
						}else if(isset($_POST[$Nome][0]) && $_POST[$Nome][0]!=''){
							$t_fonte = strtolower($Nome);
							$Fonte = ucfirst($t_fonte);
							$t_atual = strtolower($_POST[$prefixo."Tabela"]);
							$Id = ucfirst($t_atual);
							$table = $t_fonte.'_'.$t_atual;
							$sql = "delete from `".$table."` WHERE `".ucfirst(strtolower($_POST[$prefixo."Tabela"]))."`=".$_POST[$prefixo."Registro"]."";

							//echo $sql;
							//exit;

							Query($sql);

							$array_values = array();
							$array_values = explode(',',$_POST[$Nome][0]);  
							
							if(is_array($array_values)){
								foreach($array_values as $key => $value) {
									$sql_insert = 'Insert into `'.$table.'`(`'.$Fonte.'`,`'.$Id.'`) values ('.$value.','.$_POST[$prefixo."Registro"].')';
									Query($sql_insert);
									//echo $sql_insert;
								}
							}
						}     

						//exit;
						



						//exit;   

						/*if(is_array($_POST[$Nome])){
							foreach($_POST[$Nome] as $key => $value) {
								$sql_insert = 'Insert into `'.$table.'`(`'.$Fonte.'`,`'.$Id.'`) values ('.$value.','.$_POST[$prefixo."Registro"].')';
								Query($sql_insert);
							}
						}*/
					}

				return false;

				break;

				

				case "IMAGEM":

					if($Acao == 1) {

						if(isset($ArrayAssocValores[$Nome]) && $ArrayAssocValores[$Nome] != "")

							return $a.$ArrayAssocValores[$Nome].$a;

						else

							return $a." ".$a;

					} else {

						if(isset($ArrayAssocValores[$Nome]) && $ArrayAssocValores[$Nome] != "")

							return $Nome."=".$a.$ArrayAssocValores[$Nome].$a;

						else

							return NULL;

					}

				break;





				case "FILE":

					if($Acao == 1) {

						if(isset($ArrayAssocValores[$Nome]) && $ArrayAssocValores[$Nome] != "")

							return $a.$ArrayAssocValores[$Nome].$a;

						else

							return $a." ".$a;

					} else {

						if(isset($ArrayAssocValores[$Nome]) && $ArrayAssocValores[$Nome] != "")

							return $Nome."=".$a.$ArrayAssocValores[$Nome].$a;

						else

							return NULL;

					}

				break;

				

				case "CHECK":

					if($Acao == 1) {

						if(isset($_POST[$Nome]) && $_POST[$Nome] == "1")

							return 1;

						else

							return 0;

					} else {

						if(isset($_POST[$Nome]) && $_POST[$Nome] == "1")

							return $Nome."="."1";

						else

							return $Nome."="."0";

					}

				break;

				case "KEY":

					if($Acao == 1) {

						return $a.$_POST[$Nome].$a;

					} else {

						return $Nome."=".$a.$_POST[$Nome].$a;

					}

				break;

				case "INT":

				case "OPCAO":

				case "FLOAT":

					if($Acao == 1) {

						return $a.$_POST[$Nome].$a;

					} else {

						return $Nome."=".$a.$_POST[$Nome].$a;

					}

				break;

				

				case "TEXT":

					if($Acao == 1) {

						return $a.Texto($_POST["HtmlInp".$Nome], "Gravar").$a;

					} else {

						return $Nome."=".$a.Texto($_POST["HtmlInp".$Nome], "Gravar").$a;

					}

				break;

				case "KID":

				return false;

				break;




				case "VARCHAR":

					if($Acao == 1) {

						return $a.$_POST[$Nome].$a;

					} else {

						return $Nome."=".$a.clean($_POST[$Nome]).$a;

					}

				break;



				case "CROP":  

					if($Acao == 1) {

						return $a.$_SESSION['Crop_image'].$a;

					} else {

						return $Nome."=".$a.$_SESSION['Crop_image'].$a;

					}

				break;





				



				case "DATE":



					$d = explode('/',$_POST[$Nome]);

					$Data = $d[2].'-'.$d[1].'-'.$d[0];



					if($Acao == 1) {

						return $a.$Data.$a;

					} else {

						return $Nome."=".$a.$Data.$a;

					}

					



					return $Nome."=".$a.$Data.$a;



				break;

				

				default:
  


					if($Acao == 1) {

						return $a.clean($_POST["HtmlInp".$Nome]).$a;

					} else {

						return $Nome."=".$a.clean($_POST["HtmlInp".$Nome]).$a;

					}

				break;

					

			}

				

		}

		

		if(ValidarPost() == 1) {

			

			$Colunas = array(/*ucfirst(strtolower($_POST[$Config["PrefixoControle"]."Tabela"]))*/);

			

			foreach($Gerenciamentos[$_POST[$Config["PrefixoControle"]."Tabela"]] as $i => $v) {

				

				

				



				if($i!='Galeria' /*&& $Gerenciamentos[$_POST[$Config["PrefixoControle"]."Tabela"]][$i][1]!='MULTIPLE'*/){

					$Colunas[] = $i;

				}



				

			}

			

			$Query = $_POST[$Config["PrefixoControle"]."Tipo"];

			$_POST[ucfirst(strtolower($_POST[$Config["PrefixoControle"]."Tabela"]))] = NULL;

			

			if($_POST[$Config["PrefixoControle"]."Tipo"] == "INSERT") {

				$_POST[$Config["PrefixoControle"]."Tipo"] = 1;

			} else {

				$_POST[$Config["PrefixoControle"]."Tipo"] = 2;	

			}

			

			if($_POST[$Config["PrefixoControle"]."Tipo"] == 1) {

				$Query .= " INTO ";	

			} else {

				

			}

			

			$Query .= " `".strtolower($_POST[$Config["PrefixoControle"]."Tabela"]).'`';

			

			if($_POST[$Config["PrefixoControle"]."Tipo"] == 2) {

				$Query .= " SET ";

			}

			

			if($_POST[$Config["PrefixoControle"]."Tipo"] == 1) {
				$Query .= "("; 
				$flag = 0;
				foreach($Colunas as $i => $v) {
					$resp = explode('_',$v);
					if($resp[0]!='L' &&  $Gerenciamentos[$_POST[$Config["PrefixoControle"]."Tabela"]][$v][1]!='MULTIPLE'  &&  $Gerenciamentos[$_POST[$Config["PrefixoControle"]."Tabela"]][$v][1]!='MULTIPLE_IN'){
						if($flag==0){
							$Query .= $v;
							$flag = 1;	
						}else{
							if($v!=''){
								$Query .= ",".$v;
							}
						}
					}
				}
				$Query .= ",Url";
				$Query = $Query.") VALUES(";
			}

			

			/*
				Mexer em imagens
			*/

			include "WideImage/WideImage.php";

		
			$Extensoes = array(".png", ".jpg", ".jpeg", ".gif", ".bmp");

        	if (!file_exists("../imagens")) {// testo se a pasta existe
            	mkdir("../imagens",0777);
       		} 

			$Caminho = "../imagens/".strtolower($_POST[$Config["PrefixoControle"]."Tabela"])."/";
			$Folder = "../imagens/".strtolower($_POST[$Config["PrefixoControle"]."Tabela"])."";

			if(!file_exists($Folder)) {// testo se a pasta existe
            	mkdir($Folder,0777);
       		} 


			$ImagensGeradas = array();
			foreach($Gerenciamentos[$_POST[$Config["PrefixoControle"]."Tabela"]] as $i => $v) {
				if($v[1] == "IMAGEM") {
					$Nome = $_FILES[$i]['name'];
					$Temp = $_FILES[$i]['tmp_name'];
					if (in_array(strtolower(strrchr($Nome, ".")), $Extensoes)) {
						$NomeAleatorio = md5(uniqid(time())) . strrchr($Nome, ".");
						move_uploaded_file($Temp, $Caminho.$NomeAleatorio);
   						$NovaImagem = WideImage::load($Caminho.$NomeAleatorio);
						foreach($Gerenciamentos[$_POST[$Config["PrefixoControle"]."Tabela"]][$i][4] as $ii => $vi) {
							$Folder = "../imagens/".strtolower($_POST[$Config["PrefixoControle"]."Tabela"])."/".$vi[0];
							if(!file_exists($Folder)) {// testo se a pasta existe
            					mkdir($Folder,0777);
       						} 
							$resized = $NovaImagem->resize($vi[0], $vi[1],'fill');
							$resized->saveToFile($Caminho.$vi[0]."/".$NomeAleatorio);
							chmod($Caminho.$vi[0]."/".$NomeAleatorio,0755); 
						}
						unlink($Caminho.$NomeAleatorio);
						$ImagensGeradas[$i] = $NomeAleatorio;
					}
				}

				if($v[1] == "FILE") {

					if(isset($_FILES[$i])){
						$Nome = $_FILES[$i]['name'];
						$ext = explode('.',$Nome);
						if($ext[1]!=''){
							$Temp = $_FILES[$i]['tmp_name'];
							$ext = explode('.',$_FILES[$i]['name']);
							if(!file_exists($Caminho)) {// testo se a pasta existe
	            				mkdir($Caminho,0777);
	       					}
							$NomeAleatorio = md5(uniqid(time())).strrchr($Nome, ".");
							move_uploaded_file($Temp, $Caminho.$NomeAleatorio);
							$ImagensGeradas[$i] = $NomeAleatorio;
					    }
				 	}
				}
			}

			foreach($Colunas as $i => $v) {

				if($Gerenciamentos[$_POST[$Config["PrefixoControle"]."Tabela"]][$v][1] != "GALERIA") {

				if($Gerenciamentos[$_POST[$Config["PrefixoControle"]."Tabela"]][$v][1] == "IMAGEM" || $Gerenciamentos[$_POST[$Config["PrefixoControle"]."Tabela"]][$v][1] == "FILE" ) {

					if(isset($_POST["ApagarFoto".$v]) && $_POST["ApagarFoto".$v] == 1) {

						/* Apagar imagem atual. */

						$Foto = Query("SELECT ".$v." FROM ".$_POST[$Config["PrefixoControle"]."Tabela"]." WHERE ".ucfirst(strtolower($_POST[$Config["PrefixoControle"]."Tabela"]))." = ".$_POST[$Config["PrefixoControle"]."Registro"], 1);

						foreach($Gerenciamentos[$_POST[$Config["PrefixoControle"]."Tabela"]][$v][4] as $ii => $vi) {

							if(is_file($Caminho.$vi[0]."/".$Foto[$v])) {

								unlink($Caminho.$vi[0]."/".$Foto[$v]);

							}

						}

						$R = $v."=''";	

					} else {

						$R = TratarTipoDado("IMAGEM", $v, NULL, $_POST[$Config["PrefixoControle"]."Tipo"], $ImagensGeradas,$prefixo);

					}


					if($_POST[$Config["PrefixoControle"]."Tipo"] == 1 || (isset($_POST["ApagarFoto".$v]) && $_POST["ApagarFoto".$v] == 1) || ($_POST[$Config["PrefixoControle"]."Tipo"] == 2 && $R != NULL && $R != ",")) {

						$Query .= $R.",";

					} else {

						if($R != NULL && $R != ",") {

						
							/* Apagar imagem atual. */
							$Foto = Query("SELECT ".$v." FROM ".$_POST[$Config["PrefixoControle"]."Tabela"]." WHERE ".ucfirst(strtolower($_POST[$Config["PrefixoControle"]."Tabela"]))." = ".$_POST[$Config["PrefixoControle"]."Registro"], 1);

							foreach($Gerenciamentos[$_POST[$Config["PrefixoControle"]."Tabela"]][$v][4] as $ii => $vi) {

								if(is_file($Caminho.$vi[0]."/".$Foto[$v])) {

									unlink($Caminho.$vi[0]."/".$Foto[$v]);

								}

							}

							$Query .= "";



						}

					}

				  

				}else if($Gerenciamentos[$_POST[$Config["PrefixoControle"]."Tabela"]][$v][1] == "KID" || $Gerenciamentos[$_POST[$Config["PrefixoControle"]."Tabela"]][$v][1] == "KID" || $Gerenciamentos[$_POST[$Config["PrefixoControle"]."Tabela"]][$v][1] == "MULTIPLE_IN"){



				}else if($Gerenciamentos[$_POST[$Config["PrefixoControle"]."Tabela"]][$v][1]=='MULTIPLE'){

					$Query .= TratarTipoDado($Gerenciamentos[$_POST[$Config["PrefixoControle"]."Tabela"]][$v][1], $v, NULL, $_POST[$Config["PrefixoControle"]."Tipo"], NULL,$prefixo)."";

				}else {

					$Query .= TratarTipoDado($Gerenciamentos[$_POST[$Config["PrefixoControle"]."Tabela"]][$v][1], $v, NULL, $_POST[$Config["PrefixoControle"]."Tipo"], NULL,$prefixo).",";

				}



			  }

			}


			if($_POST[$Config["PrefixoControle"]."Tipo"] == 1) {
				$Query = substr($Query, 0, -1).",'".removeAcentos($_POST["Titulo"])."');";
			}

			

			if($_POST[$Config["PrefixoControle"]."Tipo"] == 2) {

				$Query = substr($Query, 0, -1)." WHERE `".ucfirst(strtolower($_POST[$Config["PrefixoControle"]."Tabela"]))."`=".$_POST[$Config["PrefixoControle"]."Registro"].";";
				
				Query("UPDATE ".$_POST[$Config["PrefixoControle"]."Tabela"]." set Url = '".removeAcentos($_POST["Titulo"])."' WHERE `".ucfirst(strtolower($_POST[$Config["PrefixoControle"]."Tabela"]))."`=".$_POST[$Config["PrefixoControle"]."Registro"]."");     


					if(isset($Config["Backlog"]) && $Config["Backlog"]==1){   
						Query('INSERT INTO historico_uso_sistema(Titulo,Data_hora,Acao,Usuario,Tabela,Registro) VALUES("UPDATE - '.$_SESSION['Sis545IdUsuario'].'",NOW(),"UPDATE",'.$_SESSION['Sis545IdUsuario'].',"'.$_POST[$Config["PrefixoControle"]."Tabela"].'","'.$_POST[$Config["PrefixoControle"]."Registro"].'")');
					}
			}
    
		

			$UrlToGo = $Config["Url"]."registros.php?1=".strtolower($_POST[$Config["PrefixoControle"]."Tabela"]);

			$novo_id = 0;


			//echo $Query; 
			//exit;

							
		//INSERT
		if($_POST[$Config['PrefixoControle'].'Tipo']==1){  
			//echo 'insert';
			//exit;
			$lastId = Insert($Query);
		}else if($_POST[$Config['PrefixoControle'].'Tipo']==2){    
			//echo 'update';
			//exit;
			Query($Query);
		}


			
				

				//é um insert
				if(!isset($_POST[$prefixo."Registro"]) || $_POST[$prefixo."Registro"]==''){
						$q_max = Query('SELECT max('.ucfirst($_POST[$Config["PrefixoControle"]."Tabela"]).') as chave from '.$_POST[$Config["PrefixoControle"]."Tabela"].'');
						$respp = mysqli_fetch_assoc($q_max);
						$novo_id = $respp['chave'];


						if(isset($Config["Backlog"]) && $Config["Backlog"]==1){   
							Query('INSERT INTO historico_uso_sistema(Titulo,Data_hora,Acao,Usuario,Tabela,Registro) VALUES("INSERT - '.$_SESSION['Sis545IdUsuario'].'",NOW(),"INSERT",'.$_SESSION['Sis545IdUsuario'].',"'.$_POST[$Config["PrefixoControle"]."Tabela"].'","'.$novo_id.'")');
						}

					foreach($Colunas as $i => $v) {
						 if($Gerenciamentos[$_POST[$Config["PrefixoControle"]."Tabela"]][$v][1]=='MULTIPLE'){
							 
								$table = explode('_',$Gerenciamentos[$_POST[$Config["PrefixoControle"]."Tabela"]][$v][2]);
								$t_fonte = strtolower($table[0]);
								$Fonte = ucfirst($t_fonte);
								$t_atual = strtolower($_POST[$Config["PrefixoControle"]."Tabela"]);
								$Id = ucfirst($t_atual);
								$table = $t_fonte.'_'.$t_atual;

				    				foreach($_POST[$Fonte] as $key => $value) {
										$sql_insert = 'Insert into '.$table.'('.$Fonte.','.$Id.') values ('.$value.','.$novo_id.')';
										Query($sql_insert);
									}
							
							}  
						}
					}

					$UrlToGo .= "&2=".$_POST['Retorno_sis']."";
	
			
		}


		//INSERT    
		if($_POST['SisValCmpTabela']=='cliente' && $_POST['SisValCmpAcao']==1){  

			Query('UPDATE cliente set Senha = "'.md5($_POST['Senha']).'" where Cliente = '.$lastId.'',0);   

		}else if($_POST['SisValCmpTabela']=='cliente' && $_POST['SisValCmpAcao']==2){  

			define('R_MD5_MATCH', '/^[a-f0-9]{32}$/i');
			if(preg_match(R_MD5_MATCH,$_POST['Senha'])) {
			    
			} else {
			   Query('UPDATE cliente set Senha = "'.md5($_POST['Senha']).'" where Cliente = '.$_POST[$prefixo."Registro"].'',0);
			}

		} 


?>
</head>
<body>
    <?php
    	if(isset($DEBUG) && $DEBUG == 1) {
	?>
            <div class="BtnDebugPro">
            	<a class="btn unit-240 noleftmargin" href="<?php echo $UrlToGo; ?>">Clique para prosseguir</a>
            </div>
        <?php
			include $Config["RootDirAdm"]."debug.php"; 
		} else {
			if(isset($_POST['Galeria_key_active']) && ($_POST['Galeria_key_active']==1) && ($_POST[$Config["PrefixoControle"]."Tipo"]==1)){
		?>
			<div id="LoadingToGo"></div>
            <script>window.location = "<?php echo $Config['Url']; ?>gerenciar.php?1=<?php echo strtolower($_POST[$Config["PrefixoControle"]."Tabela"]);  ?>&2=<?php  echo $novo_id;   ?>&Galeria=1&3=<?php echo $_POST['Retorno_sis']; ?>";</script>       
		<?php
			}else{ 
		?>
          	<div id="LoadingToGo"></div>
            <script>window.location = "<?php echo $UrlToGo; ?>";</script>
            <?php
            }	
		}
    ?>
</body>
</html>

	