<?php   include('config.php');

	$config_smtp_q = Query('SELECT * FROM configuracao_smtp WHERE Ativo = 1 ORDER BY Configuracao_smtp DESC LIMIT 1',0);

	if(mysqli_num_rows($config_smtp_q) > 0){

			$usuario = clean($_POST['login']);

			if(filter_var($usuario,FILTER_VALIDATE_EMAIL)){
				$q = Query('SELECT * FROM usuario WHERE Email = "'.$usuario.'"',0);
				if(mysqli_num_rows($q) > 0){
					$user = mysqli_fetch_assoc($q);
					$new_pwd = geraSenha();



					Query('UPDATE usuario SET Senha = MD5("'.$new_pwd.'") WHERE Usuario = '.$user['Usuario'].'');

					$conteudo = '<tr>
		                <td style="font-size: 17px; font-family: sans-serif;">
		                    Olá '.$user['Titulo'].', você solicitou uma nova senha no <b>Sistema de Gerenciamento Makeweb</b><br>
		                    Sua nova senha é: '.$new_pwd.'
							<span><a href="'.$Config['Url'].'login">Realizar Login</a></span>                
		                	</td> 
		            	</tr>';  

					Query('INSERT INTO historico_uso_sistema(Titulo,Data_hora,Acao,Usuario) VALUES("RESET PWD(SUCCESS) - '.$user["Usuario"].'",NOW(),"RESET PWD(SUCCESS)",'.$user["Usuario"].')');
 
					if(envia_email('Sistema de Gerenciamento Makeweb - Nova Senha',$conteudo,$user['Email'])){
						echo 1;
						exit;    
					}else{ 
						echo 0;
						exit;    
					}
				}else{
					Query('INSERT INTO historico_uso_sistema(Titulo,Data_hora,Acao,Usuario) VALUES("RESET PWD(FAIL) - '.$user["Usuario"].'",NOW(),"RESET PWD(FAIL)",'.$user["Usuario"].')');

					echo 0;
					exit;
				}
			}else{
			Query('INSERT INTO historico_uso_sistema(Titulo,Data_hora,Acao,Usuario) VALUES("RESET PWD(FAIL) - '.$user["Usuario"].'",NOW(),"RESET PWD(FAIL)",'.$user["Usuario"].')');

					echo 0;
					exit;
			}

	}else{
		Query('INSERT INTO historico_uso_sistema(Titulo,Data_hora,Acao,Usuario) VALUES("RESET PWD(FAIL) - '.$user["Usuario"].'",NOW(),"RESET PWD(FAIL)",'.$user["Usuario"].')');

		echo 5;
		exit;
	}