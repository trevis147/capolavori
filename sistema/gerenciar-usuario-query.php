<?php  include('config/config.php');
		
	   $id = 0;
	   $Registro  = 0;
	   $Nome  = '';
	   $Email = '';
	   $Nivel = '';
	   $Senha = '';

	   if(isset($_POST['Titulo']) && $_POST['Titulo']!=''){
	   		$Nome = clean($_POST['Titulo']);
	   }else{
	   	    echo 0;
	   }

	   if(isset($_POST['Email']) && $_POST['Email']!=''){
	   		$Email = clean($_POST['Email']);
	   }else{
	   	    echo 0;
	   }

	   if(isset($_POST['Nivel']) && $_POST['Nivel']!=''){
	   		$Nivel = clean($_POST['Nivel']);
	   }else{
	   	    echo 0;
	   }

	   if(isset($_POST['Senha']) && $_POST['Senha']!=''){
	   		$Senha = md5($_POST['Senha']);
	   }

	   //Update   
	   if(isset($_POST['Registro']) && is_numeric($_POST['Registro'])){
	   		$q_email = Query('SELECT * FROM usuario WHERE Email = "'.$Email.'" AND Usuario <> '.$_POST['Registro'].'',0);
	   		if(mysqli_num_rows($q_email)==0){
		   		//Muda senha
			   	if($Senha!=''){
			   		Query('UPDATE usuario SET Titulo = "'.$Nome.'",Email = "'.$Email.'",Nivel_usuario ="'.$Nivel.'",Senha="'.$Senha.'" WHERE Usuario = '.$_POST['Registro'].'');
			   		echo 4;
			   		exit;
			   	}else{
			   		Query('UPDATE usuario SET Titulo = "'.$Nome.'",Email = "'.$Email.'",Nivel_usuario ="'.$Nivel.'" WHERE Usuario = '.$_POST['Registro'].'');
			   		echo 2;
			   		exit;
			   	}
			}else{
				echo 3;
	   			exit;	
			}
	   //Insert
	   }else{
	   		$q_email = Query('SELECT * FROM usuario WHERE Email = "'.$Email.'"');
	   		if(mysqli_num_rows($q_email)==0){
	   			$id = Insert('INSERT INTO usuario(Titulo,Email,Nivel_usuario,Senha) VALUES ("'.$Nome.'","'.$Email.'","'.$Nivel.'","'.$Senha.'")');
	   			echo 1;
	   			exit;
	   		}else{
	   			echo 3;
	   			exit;	
	   		}
	   }



