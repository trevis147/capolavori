<?php
	include "../config.php";
	if(isset($_POST["Aprov"]) && $_POST["Aprov"] == 1) {
		
		$Caminho = $Config["RootDir"]."imagens/";
		
		function delete_files($Caminho) {
			if(is_dir($target)){
				$files = glob( $target . '*', GLOB_MARK );
				foreach( $files as $file ) {
					delete_files( $file );
				}
				rmdir( $target );
			} elseif(is_file($target)) {
				unlink( $target );
			}
		}
		
		echo "Executado.";
			
	}
?>