<?php
	include "../config.php";
	if(isset($_POST["Aprov"]) && $_POST["Aprov"] == 1) {
		
		$Caminho = $Config["RootDir"]."imagens/";
		
		foreach($Gerenciamentos as $i1 => $v1) {
			
			foreach($v1 as $i => $v) {
				if($v[1] == "IMAGEM") {
					foreach($v[4] as $ii => $vi) {
						$Pasta = $Caminho.$i1."/".$vi[0]."/";						
						echo " ".$Pasta."  <br />";	
					}
				}
			}
				
		}
		
		echo "<br />Executado.";
			
	}
?>