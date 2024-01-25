<?php
	include "../config.php";
	if(isset($_POST["Aprov"]) && $_POST["Aprov"] == 1) {
		
		$Erro = 0;
		
		$Caminho = $Config["RootDir"]."imagens/";
		
		foreach($Gerenciamentos as $i1 => $v1) {
			
			$Tabela = Query("DESCRIBE ".$i1, 0);
			
			if(isset($Tabela) && mysql_num_rows($Tabela) > 0) {
				$Colunas = array();
				
				while($t = mysql_fetch_assoc($Tabela)) {
					$Colunas[] = $t["Field"];
				}
	
				/*echo "<pre>";
				print_r($Colunas);
				echo "</pre>";*/
				
				foreach($v1 as $i => $v) {
					if(!in_array($i, $Colunas)) {
						echo "Inconsitência em: <strong>".$i1."</strong>.".$i."<br />";
						$Erro = 1;
					}
				}	
			} else {
				$Erro = 1;
				echo "<strong>A tabela ".$i1." não existe.</strong><br />";
			}

				
		}
		
		if($Erro == 0) {
			echo '<p>A correspondência da tabela com a configuração está <span class="color-green"><strong>correta</strong></span>!</p>';	
		}
		
			
	}
?>