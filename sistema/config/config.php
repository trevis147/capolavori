<?php //ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL); 
	@session_start();     
	date_default_timezone_set('America/Sao_Paulo');  
	@header('Content-Type: text/html; charset=utf-8');
	setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
	$DEBUG = 0;   
	$SQLDEBUG = array();      


	/*Host: capolavori2021.mysql.dbaas.com.br (187.45.196.223)
Banco: Capolavori2021
Usuário: Capolavori2021
Senha: Capolavo2021*/

   
    /*Banco Principal*/                   
	$Config = array(                                                                                                                                        
		"Url" => "http://desenvolvimentomw.com.br/projetos_2021/capolavori/dev/sistema/",     
		"UrlSite" => "http://desenvolvimentomw.com.br/projetos_2021/capolavori/dev/",       
		"Banco" => array("capolavori2021.mysql.dbaas.com.br","capolavori2021","Capolavo2021","capolavori2021"),     
		"PrefixoControle" => "SisValCmp",                 
		"PrefixoSessao" => "Sis545", 
		"NomeCliente" => "Capolavori",  
		"Backlog" => "1",      
		"RootDir" => $_SERVER['DOCUMENT_ROOT']."/",
		"RootDirAdm" => $_SERVER['DOCUMENT_ROOT']."/sistema/", 
		"Versao" => "1.1 (Maio/2021)" 
	);            
	        
	include "projeto_sis.php";
	include "dados.php";   
	include "idioma.php";   
	include "funcoes.php"; 


	function get_parameter(){
		$url_atual = "http" . (isset($_SERVER[HTTPS]) ? (($_SERVER[HTTPS]=="on") ? "s" : "") : "") . "://" . "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$url_ex = explode('/',$url_atual);
		$param = end($url_ex);
		return $param;
	}


		function get_count_assedio($id_aux){
			$count = Query('SELECT COUNT(*) as Total from denuncia WHERE Empresa = '.$id_aux.' AND Denuncia = 1',1);
			return $count['Total'];
		}

		function get_count_status_denuncia($id_aux,$status){
			$count = Query('SELECT COUNT(*) as Total from denuncia WHERE Empresa = '.$id_aux.' AND Status_denuncia = '.$status.'',1);
			return $count['Total'];
		}

		function get_count_denuncia($id_aux){
			$count = Query('SELECT COUNT(*) as Total from denuncia WHERE Empresa = '.$id_aux.'',1);
			return $count['Total'];
		}

		function get_count_assedio_where($id_aux,$where){
			$count = Query('SELECT COUNT(*) as Total from denuncia WHERE Empresa = '.$id_aux.' AND Denuncia = 1 '.$where.'',1);
			return $count['Total'];
		}

		function get_count_status_denuncia_where($id_aux,$status,$where){
			$count = Query('SELECT COUNT(*) as Total from denuncia WHERE Empresa = '.$id_aux.' AND Status_denuncia = '.$status.'  '.$where.'',1);
			return $count['Total'];
		}

		function get_count_denuncia_where($id_aux,$where){
			$count = Query('SELECT COUNT(*) as Total from denuncia WHERE Empresa = '.$id_aux.' '.$where.'',1);
			return $count['Total'];
		}   


	function get_gravidade_color($id){
		$q = Query('SELECT * FROM gravidade_denuncia WHERE Gravidade_denuncia = '.$id.'',0);
		if(mysqli_num_rows($q) > 0){
			$r = mysqli_fetch_assoc($q);
			return $r['Cor'];    
		}else{
			return '<span class="grav grav0" ></span>';
		}
	}



	function get_empresa($id){
		$q = Query('SELECT * FROM empresa WHERE Empresa = '.$id.'',0);
		if(mysqli_num_rows($q) > 0){
			$r = mysqli_fetch_assoc($q);
			return $r['Titulo'];
		}else{
			return 'Não cadastrado';
		}
	}

	function create_protocol($id){   
		$proto = '';
		$seed_0  = substr(str_replace(' ','',date("m d y")),-3);
		$seed_1  = substr(str_replace(' ','',date("G i s")),-3);
		$seed_2  = substr(str_replace(' ','',date("m G s")),-3);
		$seed_3  = substr(str_replace(' ','',date("i i s")),-3);

		$proto = $seed_0.'-'.$seed_1.'-'.$seed_2.'-'.$seed_3;
		return $proto;
	}   


		/*Retorna todas as cidades em forma de option*/
	function getRevendedor($id){
			$retorno = '';
			$sql = 'SELECT * from revendedor where Revendedor = '.$id.'';
			$result = Query($sql,1);
			$retorno = $result['Titulo'].' | '.$result['Empresa'];
			return $retorno;
	}

	function getStatusPedido($id){
			$retorno = '';
			$sql = 'SELECT * from status_pedido where Status_pedido = '.$id.'';
			$result = Query($sql,1);
			$retorno = $result['Titulo'];
			return $retorno;
	}





		/*Recebe o id do tipo do veiculo e devolve o nome da mesmo*/
	function getTipoVeiculo($id){
		  if($id!=''){
				$sql = 'Select Titulo from tipo where Tipo = '.$id.'';
				$query = Query($sql);
				$result = mysqli_fetch_assoc($query);
				return $result['Titulo'];
		  }else{
		  	return 'Não informado';
		  }

	}
	/*Retorna todas os documentos em forma de option*/
	function getTiposVeiculo($id){
			$retorno = '';
			$sql = 'Select Tipo,Titulo from tipo order by(Tipo) ASC';
			$query = Query($sql);
				
				while($result = mysqli_fetch_assoc($query)){
					if($id == $result['Tipo']){
						$retorno .= '<option value="'.$result['Tipo'].'" selected>'.$result['Titulo'].'</option>';
					}else{
						$retorno .= '<option value="'.$result['Tipo'].'">'.$result['Titulo'].'</option>';
					}
					
				}
				
				return $retorno;
		}



			/*Recebe o id do tipo do veiculo e devolve o nome da mesmo*/
	function getMarca($id){
		  if($id!=''){
				$sql = 'Select Titulo from marca where Marca = '.$id.'';
				$query = Query($sql);
				$result = mysqli_fetch_assoc($query);
				return $result['Titulo'];
		  }else{
		  	return 'Não informado';
		  }

	}
	/*Retorna todas os documentos em forma de option*/
	function getMarcas($id){
			$retorno = '';
			$sql = 'Select Marca,Titulo from marca order by(Marca) ASC';
			$query = Query($sql);
				
				while($result = mysqli_fetch_assoc($query)){
					if($id == $result['Marca']){
						$retorno .= '<option value="'.$result['Marca'].'" selected>'.$result['Titulo'].'</option>';
					}else{
						$retorno .= '<option value="'.$result['Marca'].'">'.$result['Titulo'].'</option>';
					}
					
				}
				
				return $retorno;
		}


  
	/*Retorna todas as cidades em forma de option*/
	function getModelo($id){
			$retorno = '';
			$sql = 'Select Titulo from modelo where Modelo = '.$id.'';
			$query = Query($sql);
			$result = mysqli_fetch_assoc($query);
			$retorno = $result['Titulo'];
			return $retorno;
	}
	/*Retorna todas as cidades em forma de option*/
	 function getModelos($id){  
		$retorno = '';
		$sql = 'Select Titulo,Modelo from modelo order by(Modelo)'; 
		$query = Query($sql);
				
		while($result = mysqli_fetch_assoc($query)){
			if($id==$result['Modelo']){
				$retorno .= '<option value="'.$result['Modelo'].'" selected>'.$result['Titulo'].'</option>';
			}else{
				$retorno .= '<option value="'.$result['Modelo'].'">'.$result['Titulo'].'</option>';	
			}
		}
		return $retorno;
	}


	/*Retorna todas as cidades em forma de option*/
	 function getVersao($id){
			$retorno = '';
			$sql = 'Select Titulo from versao where Versao = '.$id.'';
			$query = Query($sql);
			$result = mysqli_fetch_assoc($query);
			$retorno = $result['Titulo'];
			return $retorno;
	}
	/*Retorna todas as cidades em forma de option*/
	 function getVersoes($id,$marca){
		$retorno = '';
		$sql = 'Select Titulo,Versao from versao where Versao = '.$marca.' order by(Versao) ';
		$query = Query($sql);
				
		while($result = mysqli_fetch_assoc($query)){
			if($id==$result['Versao']){
				$retorno .= '<option value="'.$result['Versao'].'" selected>'.$result['Titulo'].'</option>';
			}else{
				$retorno .= '<option value="'.$result['Versao'].'">'.$result['Titulo'].'</option>';	
			}
		}
		return $retorno;
	}


	/*Retorna todas as cidades em forma de option*/
	 function getAnoFab($id){
			$retorno = '';
			$sql = 'Select Titulo from ano_fabricacao where Ano_fabricacao = '.$id.'';
			$query = Query($sql);
			$result = mysqli_fetch_assoc($query);
			$retorno = $result['Titulo'];
			return $retorno;
	}
	/*Retorna todas as cidades em forma de option*/
	 function getAnosFab($id,$marca){
		$retorno = '';
		$sql = 'Select Titulo,Ano_fabricacao from ano_fabricacao where Ano_fabricacao = '.$marca.' order by(Ano_fabricacao) ';
		$query = Query($sql);
				
		while($result = mysqli_fetch_assoc($query)){
			if($id==$result['Ano_fabricacao']){
				$retorno .= '<option value="'.$result['Ano_fabricacao'].'" selected>'.$result['Titulo'].'</option>';
			}else{
				$retorno .= '<option value="'.$result['Ano_fabricacao'].'">'.$result['Titulo'].'</option>';	
			}
		}
		return $retorno;
	}



	/*Retorna todas as cidades em forma de option*/
	function getAnoMod($id){
			$retorno = '';
			$sql = 'Select Titulo from ano_modelo where Ano_modelo = '.$id.'';
			$query = Query($sql);
			$result = mysqli_fetch_assoc($query);
			$retorno = $result['Titulo'];
			return $retorno;
	}
	/*Retorna todas as cidades em forma de option*/
	 function getAnosMod($id,$marca){
		$retorno = '';
		$sql = 'Select Titulo,Ano_modelo from ano_modelo where Ano_modelo = '.$marca.' order by(Ano_modelo) ';
		$query = Query($sql);
				
		while($result = mysqli_fetch_assoc($query)){
			if($id==$result['Ano_modelo']){
				$retorno .= '<option value="'.$result['Ano_modelo'].'" selected>'.$result['Titulo'].'</option>';
			}else{
				$retorno .= '<option value="'.$result['Ano_modelo'].'">'.$result['Titulo'].'</option>';	
			}
		}
		return $retorno;
	}

	/*Recebe o id da cor e devolve o nome da mesma*/
	 function getCor($id){
		  if($id!=''){
				$sql = 'Select Titulo from cor where Cor = '.$id.'';
				$query = Query($sql);
				$result = mysqli_fetch_assoc($query);
				return $result['Titulo'];
		  }else{
		  	return 'Não informado';
		  }

		}

	/*Retorna todas os documentos em forma de option*/
	function getCores($id){
			$retorno = '';
			$sql = 'Select Cor,Titulo from cor order by(Cor) ASC';
			$query = Query($sql);
				
				while($result = mysqli_fetch_assoc($query)){
					if($id == $result['Cor']){
						$retorno .= '<option value="'.$result['Cor'].'" selected>'.$result['Titulo'].'</option>';
					}else{
						$retorno .= '<option value="'.$result['Cor'].'">'.$result['Titulo'].'</option>';
					}
					
				}
				
				return $retorno;
		}


		/*Recebe o id da cor e devolve o nome da mesma*/
		function getCombustivel($id){
		  if($id!=''){
				$sql = 'Select Titulo from combustivel where Combustivel = '.$id.'';
				$query = Query($sql);
				$result = mysqli_fetch_assoc($query);
				return $result['Titulo'];
		  }else{
		  	return 'Não informado';  
		  }

		}

	/*Retorna todas os documentos em forma de option*/
		function getCombustiveis($id){
			$retorno = '';
			$sql = 'Select Combustivel,Titulo from combustivel order by(Combustivel) ASC';
			$query = Query($sql);
				
				while($result = mysqli_fetch_assoc($query)){
					if($id == $result['Combustivel']){
						$retorno .= '<option value="'.$result['Combustivel'].'" selected>'.$result['Titulo'].'</option>';
					}else{
						$retorno .= '<option value="'.$result['Combustivel'].'">'.$result['Titulo'].'</option>';
					}
					
				}
				
				return $retorno;
		}





		/*Recebe o id da cor e devolve o nome da mesma*/
	function getPorta($id){
		  if($id!=''){
				$sql = 'Select Titulo from porta where Porta = '.$id.'';
				$query = Query($sql);
				$result = mysqli_fetch_assoc($query);
				return $result['Titulo'];
		  }else{
		  	return 'Não informado';
		  }

		}

	/*Retorna todas os documentos em forma de option*/
		 function getPortas($id){
			$retorno = '';
			$sql = 'Select Porta,Titulo from porta order by(Porta) ASC';
			$query = Query($sql);
				
				while($result = mysqli_fetch_assoc($query)){
					if($id == $result['Porta']){
						$retorno .= '<option value="'.$result['Porta'].'" selected>'.$result['Titulo'].'</option>';
					}else{
						$retorno .= '<option value="'.$result['Porta'].'">'.$result['Titulo'].'</option>';
					}
					
				}
				
				return $retorno;
		}


	/*Recebe o id da cor e devolve o nome da mesma*/
		 function getCambio($id){
		  if($id!=''){
				$sql = 'Select Titulo from cambio where Cambio = '.$id.'';
				$query = Query($sql);
				$result = mysqli_fetch_assoc($query);
				return $result['Titulo'];
		  }else{
		  	return 'Não informado';
		  }

		}
	/*Retorna todas os cambios em forma de option*/
	 function getCambios($id){
			$retorno = '';
			$sql = 'Select Titulo,Cambio from cambio order by(Cambio) ASC';
			$query = Query($sql);
				
				while($result = mysqli_fetch_assoc($query)){
					if($id == $result['Cambio']){
						$retorno .= '<option value="'.$result['Cambio'].'" selected>'.$result['Titulo'].'</option>';
					}else{
						$retorno .= '<option value="'.$result['Cambio'].'">'.$result['Titulo'].'</option>';
					}
					
				}
				
				return $retorno;
		}


			/*Recebe o id da cor e devolve o nome da mesma*/
		 function getBlindagem($id){
		  if($id!=''){
				$sql = 'Select Titulo from blindagem where Blindagem = '.$id.'';
				$query = Query($sql);
				$result = mysqli_fetch_assoc($query);
				return $result['Titulo'];
		  }else{
		  	return 'Não informado';
		  }
  
		}
	/*Retorna todas os cambios em forma de option*/
	 function getBlindagens($id){  
			$retorno = '';
			$sql = 'Select Titulo,Blindagem from blindagem order by(Blindagem) ASC';
			$query = Query($sql);
				
				while($result = mysqli_fetch_assoc($query)){
					if($id == $result['Blindagem']){
						$retorno .= '<option value="'.$result['Blindagem'].'" selected>'.$result['Titulo'].'</option>';
					}else{
						$retorno .= '<option value="'.$result['Blindagem'].'">'.$result['Titulo'].'</option>';
					}
					
				}
				
				return $retorno;
		}


	function getSituacaoVec($id){
		if($id!=''){
				$sql = 'Select Titulo from situacao_veiculo where Situacao_veiculo = '.$id.'';
				$query = Query($sql);
				$result = mysqli_fetch_assoc($query);
				return $result['Titulo'];
		  }else{   
		  	return 'Não informado';
		  }
	}


	/*Retorna todas as cidades em forma de option*/
	 function getMaxAnoFab(){
			$retorno = '';
			$sql = 'Select MAX(Titulo) as Maximo from ano_fabricacao';
			$query = Query($sql);
			$result = mysqli_fetch_assoc($query);
			$retorno = $result['Maximo'];
			return $retorno;
	}
  
	/*Retorna todas as cidades em forma de option*/
	 function getMinAnoFab(){
			$retorno = '';
			$sql = 'Select MIN(Titulo) as Minimo from ano_fabricacao';
			$query = Query($sql);
			$result = mysqli_fetch_assoc($query);
			$retorno = $result['Minimo'];
			return $retorno;
	}
  

	/*Retorna todas as cidades em forma de option*/
	 function getMaxValor(){
			$retorno = '';
			$sql = 'Select MAX(Valor_final) as Maximo from veiculo';
			$query = Query($sql);
			$result = mysqli_fetch_assoc($query);
			$retorno = $result['Maximo'];
			return $retorno;
	}

  
	/*Retorna todas as cidades em forma de option*/
	 function getMinValor(){
			$retorno = '';
			$sql = 'Select MIN(Valor_final) as Minimo from veiculo';
			$query = Query($sql);
			$result = mysqli_fetch_assoc($query);
			$retorno = $result['Minimo'];
			return $retorno;
	}

   
	/*Retorna todas as cidades em forma de option*/
	 function getLoja($id){
			$retorno = '';
			$sql = 'Select Titulo from loja where Loja = '.$id.'';
			$query = Query($sql); 
			$result = mysqli_fetch_assoc($query);
			$retorno = $result['Titulo'];
			//$retorno = $sql;
			return $retorno;
	}

	if(isset($_IS_REQ) && $_IS_REQ==1){ 
		// Allow from any origin
		if (isset($_SERVER['HTTP_ORIGIN'])) {
		    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
		    header('Access-Control-Allow-Credentials: true');
		    header('Access-Control-Max-Age: 86400');    // cache for 1 day
		}
		// Access-Control headers are received during OPTIONS requests
		if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

		    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
		        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");         

		    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
		        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
		    
		}
	}     
	 

    function envia_email($assunto,$corpo,$email){ 
 
		global $Config;
   
		//$message = $corpo;			
		$destino = $email; 

		$config_smtp = Query('SELECT * FROM configuracao_smtp WHERE Ativo = 1 ORDER BY Configuracao_smtp DESC LIMIT 1',1);
  
        
		$usuario = $config_smtp['Email_sender'];      
		$senha   = $config_smtp['Senha_sender']; 
	//$destinatarios = $config_smtp['Destinatarios'];
            
 
	   $conteudo = '
		<!DOCTYPE html
		PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml">   
			<head>
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
				<title>CRMake</title>
				<meta name="viewport" content="width=device-width, initial-scale=1.0" />
			</head>
			<body bgcolor="#eee" style="margin: 0; padding: 50px 0 50px 0; background-color: #eee; padding: 30px 0;">
				<table bgcolor="#eee"align="center" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #eee">
					<table align="center" bgcolor="transparent" border="0" bordercolor="#e13a4a" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse; background-color: transparent; width: 600px; margin: 0 auto;">
						<tr>     
							<td align="center" style="padding: 0;">
								<img src="'.$Config['Url'].'img/top.png" alt="Audax Cursos Profissionalizantes" width="600" height="130" style="display: block; margin-bottom: -20px;" />
							</td>
						</tr>
						<tr bgcolor="#fff" style="font-family: Arial,Helvetica,sans-serif; font-size: 14px; color: #989898; background-color: #fff;">';
							$conteudo .=  $corpo; 
							$conteudo .= '<tr>
							<td align="center" bgcolor="transparent" style="padding: 0;">
								<img src="'.$Config['Url'].'img/bottom.png" alt="Audax Cursos Profissionalizantes" width="600" height="51" style="display: block; border-radius: 0 0 15px 15px; margin-top: -20px;" />
							</td>
						</tr>
					</table>
				</table>
			</body>
		</html>';



		$message = $conteudo;



	/***********************************A PARTIR DAQUI NAO ALTERAR*********************************** */

		require_once('class.phpmailer.php');  

		$Subject = utf8_decode($assunto);
		$Message = utf8_decode($message);    

		$Host = 'mail.'.substr(strstr($usuario,'@'),1);
		//$Host = 'smtp.desenvolvimentomw.com.br'; 
		$Username = $usuario;
		$Password = $senha;
		$Port = "587"; 
          
		$mail = new PHPMailer();    
		$body = $Message;   
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->Host = $Host; // SMTP server
		$mail->SMTPDebug = 0; // enables SMTP debug information (for testing)
		$mail->SMTPAuth = true; // enable SMTP authentication
		$mail->Port = $Port; // set the SMTP port for the service server
		$mail->Username = $usuario; // account username
		$mail->Password = $senha; // account password
		$mail->SetFrom($usuario,"Contato");    
		$mail->Subject = $Subject;
		$mail->MsgHTML($body);    
		//$mail->AddAttachment($_FILES['arquivo']['tmp_name'], $_FILES['arquivo']['name']);
	   		
		$mail->AddAddress($email,$email);


	   		        
	    // $mail->AddAddress('lucas@makeweb.com.br',"Contato");
		if($mail->Send()){
			return 1;
		}else{ 
			return 0;
		}

	} 























	







   	
?>
