<?php
	include "./config/config.php";
	
	session_start();
	if (!isset($_SESSION['Sis545IdUsuario'])) {
	    session_destroy();
	    echo 0;
	    exit;
	}

	if(isset($_POST["Registro"]) && is_numeric($_POST["Registro"]) && $_POST["Registro"] > 0 && isset($_POST["Tabela"]) && $_POST["Tabela"] != "") {
		
		$tabela = clean($_POST["Tabela"]);
		$registro = clean($_POST["Registro"]); 

		$Caminho = "../imagens/".strtolower($_POST["Tabela"])."/";
		
		foreach($Gerenciamentos[$_POST["Tabela"]] as $i => $v) {

			if($Gerenciamentos[$_POST["Tabela"]][$i][1] == "IMAGEM") {
				$Foto = Query("SELECT ".$i." FROM ".$tabela." WHERE ".ucfirst(strtolower($tabela))." = ".$registro, 1);
				foreach($Gerenciamentos[$_POST["Tabela"]][$i][4] as $ii => $vi) {
					if(is_file($Caminho.$vi[0]."/".$Foto[$i])) {
							unlink($Caminho.$vi[0]."/".$Foto[$i]);
							//echo $Caminho.$vi[0]."/".$Foto[$i]."<br />";
						}
					}	
			}else if($Gerenciamentos[$_POST["Tabela"]][$i][1] == "KID"){
				Query('DELETE FROM '.$Gerenciamentos[$_POST["Tabela"]][$i][2].' WHERE '.ucfirst($tabela).' = '.$registro.'');
			}else if($Gerenciamentos[$_POST["Tabela"]][$i][1] == "MULTIPLE"){
				Query('DELETE FROM '.$Gerenciamentos[$_POST["Tabela"]][$i][2].' WHERE '.ucfirst($tabela).' = '.$registro.'');
			}else if($Gerenciamentos[$_POST["Tabela"]][$i][1] == "MULTIPLE_IN"){  
				Query('DELETE FROM '.$Gerenciamentos[$_POST["Tabela"]][$i][2].' WHERE '.ucfirst($tabela).' = '.$registro.'');
			}      
		}     
		
		Query("DELETE FROM ".$tabela." WHERE ".ucfirst(strtolower($tabela))." = ".$registro, 0);        
		  
		if(isset($Config["Backlog"]) && $Config["Backlog"]==1){   
			Query('INSERT INTO historico_uso_sistema(Titulo,Data_hora,Acao,Usuario,Tabela,Registro) VALUES("DELETE - '.$_SESSION['Sis545IdUsuario'].'",NOW(),"DELETE",'.$_SESSION['Sis545IdUsuario'].',"'.$tabela.'","'.$registro.'")');
		}	

		/*if($_POST["Tabela"]=='empresa'){    
			Query('DELETE  FROM responsavel 	WHERE Empresa = '.$_POST["Registro"].'');
			Query('DELETE  FROM denuncia 		WHERE Empresa = '.$_POST["Registro"].'');
			Query('DELETE  FROM pagamento 		WHERE Empresa = '.$_POST["Registro"].'');
			Query('DELETE  FROM certidao 		WHERE Empresa = '.$_POST["Registro"].'');
			Query('DELETE  FROM denuncia_cert 	WHERE Empresa = '.$_POST["Registro"].'');     
		}    */
    




		echo 1;
		exit; 
	} else {
		echo 0;	
		exit; 
	}
	
?>