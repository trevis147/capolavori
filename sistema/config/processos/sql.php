<?php
	include "../config.php";
	if(isset($_POST["Aprov"]) && $_POST["Aprov"] == 1) {
		
		if(isset($_POST["Query"]) && $_POST["Query"] != "") {
			$s = Query($_POST["Query"], 0);
			?>
				<p>Query enviada com sucesso.</p>
			<?php	
		} else {
			?>
				<p><strong>Você não informou nenhuma query.</strong></p>
			<?php		
		}

	} else {
			?>
				<p>Erro desconhecido.</p>
			<?php		
		}
?>