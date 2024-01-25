<?php
	include "../config.php";
	if(isset($_POST["Aprov"]) && $_POST["Aprov"] == 1) {
		
		?>
        <p>Dados da conexão:</p>
        <p>
        	<strong>Servidor:</strong> <?php echo $Config["Banco"][0]; ?> <br />
        	<strong>Usuário:</strong> <?php echo $Config["Banco"][1]; ?> <br />
        	<strong>Senha:</strong> <?php echo $Config["Banco"][2]; ?> <br />
        	<strong>Banco de dados:</strong> <?php echo $Config["Banco"][3]; ?>
        </p>
        <?php
		
		
		foreach($Gerenciamentos as $i => $v) {
			
			$s = Query("SELECT COUNT(*) AS Total FROM ".$i, 1);
			if(isset($s["Total"]) && is_numeric($s["Total"])) {
				 ?>
				 <p>Conexão estabelecida com sucesso.</p>
				 <?php	
			} else {
				 ?>
				 <p><strong>A conexão não foi estabelecida.</strong> Ocorreu um erro na tentativa da conexão.</p>
				 <?php	
			}
			break;	
		}
			
	}
?>