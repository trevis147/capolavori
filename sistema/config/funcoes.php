<?php

	
	if(!isset($Autentica)){
		$Autentica = 0;
	}

	
function formatador_de_preco($v){
    $v_0 = str_replace('.','',$v);
    $v_1 = str_replace(',','.',$v_0);
    return $v_1;
}
		
	function removeAcentos($string, $separator = '-') {

        $accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';

        $special_cases = array('&' => 'and');

        $string = mb_strtolower(trim($string), 'UTF-8');

        $string = str_replace(array_keys($special_cases), array_values($special_cases), $string);

        $string = preg_replace($accents_regex, '$1', htmlentities($string, ENT_QUOTES, 'UTF-8'));

        $string = preg_replace("/[^a-z0-9]/u", "$separator", $string);

        $string = preg_replace("/[$separator]+/u", "$separator", $string);

        return $string;

    }

     
	function come_credito($modelo,$user,$cred = 1,$tipo_chat = 1,$chat_id = 0){
		      
       $q = Query('SELECT Saldo FROM user WHERE User = '.$user.'',0);   
       $q_modelo = Query('SELECT Saldo,User,Porcentagem_album_videos FROM user WHERE User = '.$modelo.'',0);   

       if((mysqli_num_rows($q) > 0) && (mysqli_num_rows($q_modelo) > 0)){
         $r     = mysqli_fetch_assoc($q);
         $r_modelo   = mysqli_fetch_assoc($q_modelo);

         $saldo = $r['Saldo'];    

        $id_pgto = 0;
        $percent = 0;
        $name_field = '';   

        if($tipo_chat==1){
        	$name_field = 'Porcentagem_chat_privado';
        	$name_field_2 = 'Credito_intervalo_video_privado';
        }else if($tipo_chat==2){
        	$name_field = 'Porcentagem_chat_exclusivo';
        	$name_field_2 = 'Credito_intervalo_video_exclusivo';
        }

        $q_config_pagto = Query('SELECT * FROM configuracao_pagamento WHERE Ativo = 1 ORDER BY Configuracao_pagamento DESC LIMIT 1');
        if(mysqli_num_rows($q_config_pagto) > 0){
            $r_config_pagto = mysqli_fetch_assoc($q_config_pagto);
            
            if($r_config_pagto[$name_field]!='' && is_numeric($r_config_pagto[$name_field]) && $r_config_pagto[$name_field]> 0){
                $percent = $r_config_pagto[$name_field];

                if($r_config_pagto[$name_field_2]!='' && is_numeric($r_config_pagto[$name_field_2]) && $r_config_pagto[$name_field_2]> 0){
                	$cred = $r_config_pagto[$name_field_2];
            	}

            }else{
                $resposta['status'] = 0;
                return $resposta;
            }
        }else{
            $resposta['status'] = 0;
            return $resposta;      
        }
     
         
        if(isset($saldo) && (is_numeric($saldo) && ($saldo >= $cred))){

            $id_pgto = Insert('INSERT INTO `transacao`(`Usuario`,`Modelo`,`Produto`, `Id`, `Data`, `Data_limite`,`Credito`,`Tipo_transacao`,`Ativo`) VALUES ('.$user.','.$modelo.',"compra de streaming",'.$chat_id.',NOW(),DATE_ADD(NOW(),INTERVAL 30 second),'.$cred.','.$tipo_chat.',0)');      
            
            if($id_pgto!=0 && is_numeric($cred) && $cred > 0){

               if($r_modelo[$name_field]!='' && is_numeric($r_modelo[$name_field]) && $r_modelo[$name_field] > 0){
                   $percent = $r_modelo[$name_field];
               }
    
                $valor_modelo  = getPercentOfNumber($cred,$percent);
                $saldo_modelo  = $r_modelo['Saldo'] + $valor_modelo;

                $valor_site    = $cred - $valor_modelo;
                $saldo_site    = $r_config_saldo_site['Creditos'] + $valor_site;
   
                $saldo = $saldo - $cred;

                $resposta['video'] = '';         
   
                Query('UPDATE user SET Saldo = "'.$saldo.'" WHERE User = '.$_SESSION['User'].'',0);
                Query('UPDATE user SET Saldo = "'.$saldo_modelo.'" WHERE User = '.$r_modelo['User'].'');
                Query('UPDATE saldo_do_site SET Creditos = "'.$saldo_site.'" WHERE Saldo_do_site = '.$r_config_saldo_site['Saldo_do_site'].'');

                Query('UPDATE `transacao` SET Ativo = 1,Saldo_modelo="'.$valor_modelo.'",Saldo_site="'.$valor_site.'" WHERE `Transacao` = '.$id_pgto.'');
                    
                $resposta['id_pgto'] = $id_pgto;
                $resposta['status'] = 1;
                return $resposta;
            
            }else{
                $resposta['status'] = 9;
                return $resposta;
            }
         
         }else{
            $resposta['status'] = 2;
            return $resposta;
         }
       }
	}





	function google_captcha($response){ 
		$data = http_build_query(
	    array(
	        'secret' => '6LfIXxEUAAAAAL6chopHTcl6UXjVer9_1wh9y9L3',  
	        'response' => $response,
	        'remoteip' => $_SERVER['REMOTE_ADDR']
	    	)  
		);   
            
		$stream = array('http' => 
	    	array(
	        	'method'  => 'POST',
	        	'header'  => 'Content-type: application/x-www-form-urlencoded',
	        	'content' => $data
	    	)
		);             

		$context  = stream_context_create($stream);
		$result = file_get_contents('https://www.google.com/recaptcha/api/siteverify',false,$context);

		return json_decode($result);
	}
	
	function getPercentOfNumber($number, $percent){
    	return ($percent / 100) * $number;
	}

	function get($table,$id){     
		$resp = Query('SELECT Titulo FROM '.$table.' WHERE '.ucfirst($table).' = '.$id.'',1);   
		return $resp['Titulo']; 
	}

	function get_url($table,$id){     
		$resp = Query('SELECT Url FROM '.$table.' WHERE '.ucfirst($table).' = '.$id.'',1);   
		return $resp['Url']; 
	}

	function get_table_attr($table,$attr,$id){ 
		$resp = Query('SELECT '.$attr.' as Atributo FROM '.$table.' WHERE '.ucfirst($table).' = '.$id.'',1);   
		return $resp['Atributo']; 
	}

	function prepara_label($label){   
		$labels = explode('_',$label); 
		$rotulo = '';

		foreach ($labels as $key => $value) {
			$rotulo .= ' <b>'.ucfirst($value).'</b>';
		}

		return $rotulo;
	}


	function get_client_ip() {   
	    $ipaddress = '';
	    if (getenv('HTTP_CLIENT_IP'))
	        $ipaddress = getenv('HTTP_CLIENT_IP');
	    else if(getenv('HTTP_X_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	    else if(getenv('HTTP_X_FORWARDED'))
	        $ipaddress = getenv('HTTP_X_FORWARDED');
	    else if(getenv('HTTP_FORWARDED_FOR'))
	        $ipaddress = getenv('HTTP_FORWARDED_FOR');
	    else if(getenv('HTTP_FORWARDED'))
	       $ipaddress = getenv('HTTP_FORWARDED');
	    else if(getenv('REMOTE_ADDR'))
	        $ipaddress = getenv('REMOTE_ADDR');
	    else
	        $ipaddress = 'UNKNOWN';
	    return $ipaddress;
    }

	function get_nivel($nivel){
		$resp = Query('SELECT Titulo FROM nivel_usuario WHERE Nivel_usuario = '.$nivel.'',1);   
		
		return $resp['Titulo']; 
	}


	function  get_filtro($id){
		$resp = Query('SELECT Url FROM filtro_galeria WHERE Filtro_galeria = '.$id.'',1);   
		return $resp['Url'];
	}

	function get_color_css($css){ 
		$resp = Query('SELECT Css FROM coloracao WHERE Coloracao = '.$css.'',1);   
		return $resp['Css'];
	}

	function get_color_css_2($css){ 
		$resp = Query('SELECT Css_2 FROM coloracao WHERE Coloracao = '.$css.'',1);   
		return '0 4px 0 0 '.$resp['Css_2'];
	}

	function get_url_cat($id){    
		$resp = Query('SELECT Url FROM categoria_blog WHERE Categoria_blog = '.$id.'',1);   
		return $resp['Url']; 
	}


	  function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false){     
          $lmin = 'abcdefghijklmnopqrstuvwxyz';
          $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $num = '1234567890';
          $simb = '!@#$%*-';
          $retorno = '';
          $caracteres = '';
          $caracteres .= $lmin;
          if ($maiusculas) $caracteres .= $lmai;
          if ($numeros) $caracteres .= $num;
          if ($simbolos) $caracteres .= $simb;
          $len = strlen($caracteres);
          for ($n = 1; $n <= $tamanho; $n++) {
          $rand = mt_rand(1, $len);
          $retorno .= $caracteres[$rand-1];
          }
          return $retorno;
	}

	function goHome(){ 
		global $Config;
		echo '<script>document.location = "'.$Config['UrlSite'].'";</script>';
		exit; 
	}

	function get_mes($ind){    
		$meses = array('Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro');
		if(is_numeric($ind)){    
			return $meses[$ind-1];
		}else{
			return 'Mês';
		}
	}


	function get_data($url) {   
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	} 
		
	
	function EstaLogado() {   
		
		global $Config;
		global $Autentica;
		
		if($Autentica == 0) {
			if(isset($DEBUG) && $DEBUG == 1) {
				if(!isset($_SESSION[$Config["PrefixoSessao"]."IdUsuario"]) || !is_numeric($_SESSION[$Config["PrefixoSessao"]."IdUsuario"])) {
					$_SESSION[$Config["PrefixoSessao"]."IdUsuario"] = 0;
					$_SESSION[$Config["PrefixoSessao"]."Nome"] = "Desenvolvedor";
				}
			}
			if(!isset($_SESSION[$Config["PrefixoSessao"]."IdUsuario"]) || !is_numeric($_SESSION[$Config["PrefixoSessao"]."IdUsuario"])) {
				header("Location: ".$Config["Url"]."login"); exit;
			}	
		}

	}


	function data_americana($data){ 
		$d = explode('/',$data);
		return $d[2].'-'.$d[1].'-'.$d[0];
	}


	function clean($str) {         
		global $Config;
		global $DEBUG;
		global $SQLDEBUG;

		$Conexao = Conectar($Config["Banco"][0],$Config["Banco"][1],$Config["Banco"][2],$Config["Banco"][3]);



    	if(!is_numeric($str)) {  
    		$str = strip_tags($str);    
        	$str = get_magic_quotes_gpc() ? stripslashes($str) : $str;
        	$str = function_exists('mysqli_real_escape_string') ? mysqli_real_escape_string($Conexao,$str) : mysqli_escape_string($Conexao,$str);
    	}  

    	Desconectar($Conexao);
		unset($Dados);   
    	return $str;
	}
	
	//EstaLogado();
	
	function formata_data($d){   
		$d = explode('-',$d);
		return $d[2].'/'.$d[1].'/'.$d[0];
	}

		function formata_data_hora($data){
		$d_aux = explode(' ',$data);
		$d = formata_data($d_aux[0]);
		return $d.' - '.$d_aux[1];
	}  

	function getAno($id){
		$r = Query('SELECT * from ano where Ano = '.$id.'',1);
		return $r['Titulo'];   
	}


	function getGravidade($id){
		if($id!=0){
			$r = Query('SELECT Titulo from gravidade_denuncia where Gravidade_denuncia = '.$id.'',1);
			return $r['Titulo']; 
		}else{
			return utf8_encode('Não avaliado');
		}
	}


	function Insert($Sql){  
		global $Config;
		global $DEBUG;
		global $SQLDEBUG;

		$Conexao = Conectar($Config["Banco"][0],$Config["Banco"][1],$Config["Banco"][2],$Config["Banco"][3]);
		mysqli_query($Conexao,$Sql);
		$lastId = mysqli_insert_id($Conexao);
		return $lastId;
	}

	
	function getMes($id){
		$r = Query('SELECT * from mes where Mes = '.$id.'',1);
		return $r['Titulo'];
	} 



	function form_ajax(){ 
		global $Config;

 		echo  '$(".google_captcha").submit(function(e){
						
						var valid_form = $(this).valid(); 						
						if (valid_form) {
        		
			        		var form = $(this)[0]; // You need to use standart javascript object here
	        				var dados = new FormData(form);

			        		$.ajax({
			                	  url : "'.$Config['UrlSite'].'envia_contato", /* URL que será chamada */ 
			                	  type: "POST",
						          data:  dados,
						          mimeType:"multipart/form-data",
						          contentType: false,  
						          cache: false,
						          processData:false,  
			                success: function(data){
			                    if(data==1){
			 						swal({
							          title: "Sucesso",
							          text: "Envio realizado com sucesso",
							          type: "success",
							          confirmButtonText: "Ok"           
							        });
			               		}else if(data==2){
			                    	 swal({
							          title: "Aviso",
							          text: "Preencha o captcha!",
							          type: "warning",
							          confirmButtonText: "Ok"         
							        });
			                	}else if(data==0){
			        		        swal({   
							          title: "Erro",
							          text: "Erro no envio",
							          type: "error",
							          confirmButtonText: "Fechar"         
							        }, function() {
							           
							          }
							        );
			                 	   }else{
			                 	   	document.location = data;
			                 	   }
			                	}
			           		}); 			        		
			        		return false;
			        	}
        		});';
	}

	
	function Conectar($Servidor, $Usuario, $Senha, $Banco) {
		$Conexao = mysqli_connect($Servidor,$Usuario,$Senha,$Banco) or die("ERRO: Configuração inválida de banco de dados.");
		//mysql_select_db($Banco, $Conexao) or die("ERRO: Banco não encontrado");
		mysqli_set_charset($Conexao,"utf8");
		return $Conexao;
	}   
	
	function Desconectar($Conexao) {
		$Conexao = "";
		unset($Conexao);
	}
	
	function Query($Sql, $Fetch = 0) {
		
		global $Config;
		global $DEBUG;
		global $SQLDEBUG;
		
		$Conexao = Conectar($Config["Banco"][0],$Config["Banco"][1],$Config["Banco"][2],$Config["Banco"][3]);
		$Dados = mysqli_query($Conexao,$Sql);
		
		if(isset($DEBUG) && $DEBUG == 1) {
			$SQLDEBUG[] = $Sql;
		}
		
		if($Fetch == 1) {
			$Retorno = @mysqli_fetch_assoc($Dados);
		} else {
			$Retorno = $Dados;
		}
		
		Desconectar($Conexao);
		unset($Dados);
		return $Retorno;
	}



	function Query_bd2($Sql, $Fetch = 0) { 
		
		global $Config_1;
		global $DEBUG;
		global $SQLDEBUG;
		
		$Conexao = Conectar($Config_1["Banco"][0],$Config_1["Banco"][1],$Config_1["Banco"][2],$Config_1["Banco"][3]);
		$Dados = mysqli_query($Conexao,$Sql);
		
		if(isset($DEBUG) && $DEBUG == 1) {
			$SQLDEBUG[] = $Sql;
		}
		
		if($Fetch == 1) {
			$Retorno = @mysqli_fetch_assoc($Dados);
		} else {
			$Retorno = $Dados;
		}
		   
		Desconectar($Conexao);
		unset($Dados);   
		return $Retorno;
	}
	
	function ErroMsg($Msg) {
		?>
        <div class="message message-error">
        <span class="close"></span>
        <?php echo $Msg; ?>
        </div>
        <?php
	}
	
	function SucessoMsg($Msg) {
		?>
        <div class="message message-success">
        <span class="close"></span>
        <?php echo $Msg; ?>
        </div>
        <?php
	}
	
	function Nomes($Termo) {
		
		global $AjusteIdioma;
		
		if(array_key_exists(strtolower($Termo), $AjusteIdioma))
			return ucfirst($AjusteIdioma[strtolower($Termo)]);
		else	
			return $Termo;
	}
	
	function Texto($Texto, $Acao = 'Ler') {
		if($Acao == 'Gravar') {
			return htmlspecialchars($Texto, ENT_QUOTES);
		} else {
			return htmlspecialchars_decode($Texto, ENT_QUOTES);	
		}
	}
	
	function CriarQuerySimples($Comando, $Colunas, $From, $Ordem = NULL,$Where = NULL) {
		
		$Sql = strtoupper($Comando)." ";
		foreach($Colunas as $i => $v) {
			$Sql .= "`".$v."`,";
		}
		$Sql = substr($Sql, 0, -1);
		$Sql .= " FROM `".strtolower($From)."`";
				if($Where != NULL) {

			$Sql .= " Where `".ucfirst($Where[0]).'`='.$Where[1].' ';

		}

		if($Ordem != NULL) {
			$Sql .= " ORDER BY `".ucfirst(strtolower($From))."`";
		}



		//echo $Sql;
		//exit;
		return $Sql;
		
	}
	
	function ValidarPost() {

		global $Config;

		if(isset($_POST[$Config["PrefixoControle"]."Acao"]) && is_numeric($_POST[$Config["PrefixoControle"]."Acao"]) && in_array($_POST[$Config["PrefixoControle"]."Acao"], array(1,2))) {
			if(isset($_POST[$Config["PrefixoControle"]."Tabela"]) && $_POST[$Config["PrefixoControle"]."Tabela"] != "") {
				if(isset($_POST[$Config["PrefixoControle"]."Tipo"]) &&$_POST[$Config["PrefixoControle"]."Tipo"] != "" && in_array($_POST[$Config["PrefixoControle"]."Tipo"], array("INSERT","UPDATE"))) {
					return 1;	
				}
			} else {
				return 0;
			}
		} else {
			return 0;
		}
			
	}
	
	function Email($Para, $Assunto, $Mensagem, $De) {
			
		$Def['Nome'] = $De['Nome'];
		$Def['Email'] = $De['Email'];
		
		$Msg = '<html><head></head><body>'.$Mensagem.'</body></html>';
		
		if(PHP_OS == "Linux") $QL = "\n";
		elseif(PHP_OS == "WINNT") $QL = "\r\n";
		else die("Este script nao esta preparado para funcionar com o sistema operacional de seu servidor.");
		
		
		$headers = "MIME-Version: 1.1".$QL;
		$headers.= "Content-type: text/html; charset=utf-8".$QL;
		$headers.= "Content-Transfer-Encoding: 8bit".$QL;
		$headers.= "From: ".$Def['Nome']." <".$Def['Email'].">".$QL;
		$headers.= "Reply-To: ".$De['Email']."".$QL;
		$headers.= "Return-Path: ".$Def['Email']."".$QL;   
		
		if(!mail($Para, $Assunto, $Msg, $headers ,"-r".$Def['Email'])){
			$headers .= "Return-Path: " . $Def['Email'] . $QL;
			mail($Para, $Assunto, $Msg, $headers);
		}
		
		return TRUE;

	}

	 function cria_pasta($caminho) {
        foreach ($caminho as $value => $key) {
            if (!file_exists($caminho[$value])) {
                mkdir($caminho[$value], 0777);
            }
        }
    }

    function apaga_arquivo($caminho, $arquivo) {
        foreach ($caminho as $value) {
            if (file_exists($caminho[$value] . $arquivo[$value])) {
                unlink($caminho[$value] . $arquivo[$value]);
            }
        }
    }
	
	function upload_arquivo($nome_arquivo, $tmp, $caminho) {
        $caminho_final = $caminho . $nome_arquivo;
        if (move_uploaded_file($tmp, $caminho_final))
            return true;
    }
	
     function upload_altura($file, $path, $alt, $maxsize = 900720000) {
        if (is_uploaded_file($file['tmp_name'])) {
            $mime = $file['type'];
            if (($mime != "")) {
                if ($file['size'] < $maxsize) {
                    list($larg_orig, $alt_orig) = getimagesize($file['tmp_name']);
                    $razao_orig = $alt_orig / $larg_orig;
                    $larg = $alt / $razao_orig;
                    $imagem_nova = imagecreatetruecolor($larg, $alt);
                    if ($file['type'] == 'image/png') {
                        $imagem = imagecreatefrompng($file['tmp_name']);
                    } elseif ($file['type'] == 'image/gif' || $_FILES['arquivo']['type'] == 'image/gif') {
                        $imagem = imagecreatefromgif($file['tmp_name']);
                    } else {
                        $imagem = imagecreatefromjpeg($file['tmp_name']);
                    } imagecopyresampled($imagem_nova, $imagem, 0, 0, 0, 0, $larg, $alt, $larg_orig, $alt_orig);
                    return (imagejpeg($imagem_nova, $path, 100)) ? 1 : 5;
                }
            }
        }
    }

	function upload_largura($file, $path, $larg, $maxsize = 900720000) {
        if (is_uploaded_file($file['tmp_name'])) {
            $mime = $file['type'];
            if (($mime != "")) {
                if ($file['size'] < $maxsize) {
                    list($larg_orig, $alt_orig) = getimagesize($file['tmp_name']);
                    $razao_orig = $larg_orig / $alt_orig;
                    $larg = $larg;
                    $alt = $larg / $razao_orig;
                    $imagem_nova = imagecreatetruecolor($larg, $alt);
                    if ($file['type'] == 'image/png') {
                        $imagem = imagecreatefrompng($file['tmp_name']);
                    } elseif ($file['type'] == 'image/gif' || $_FILES['arquivo']['type'] == 'image/gif') {
                        $imagem = imagecreatefromgif($file['tmp_name']);
                    } else {
                        $imagem = imagecreatefromjpeg($file['tmp_name']);
                    } imagecopyresampled($imagem_nova, $imagem, 0, 0, 0, 0, $larg, $alt, $larg_orig, $alt_orig);
                    return (imagejpeg($imagem_nova, $path, 100)) ? 1 : 5;
                }
            }
        }
    }
	
	 function upload_larg_alt($file, $path, $larg, $alt, $maxsize = 900720000) {
        if (is_uploaded_file($file['tmp_name'])) {
            $mime = $file['type'];
            if (($mime != "")) {
                if ($file['size'] < $maxsize) {
                    list($larg_orig, $alt_orig) = getimagesize($file['tmp_name']);
                    $imagem_nova = imagecreatetruecolor($larg, $alt);
                    if ($file['type'] == 'image/png') {
                        $imagem = imagecreatefrompng($file['tmp_name']);
                    } elseif ($file['type'] == 'image/gif' || $_FILES['arquivo']['type'] == 'image/gif') {
                        $imagem = imagecreatefromgif($file['tmp_name']);
                    } else {
                        $imagem = imagecreatefromjpeg($file['tmp_name']);
                    } imagecopyresampled($imagem_nova, $imagem, 0, 0, 0, 0, $larg, $alt, $larg_orig, $alt_orig);
                    return (imagejpeg($imagem_nova, $path, 100)) ? 1 : 5;
                }
            }
        }
    }

    function read($param){             
		$id = 0;

		if(isset($_GET[$param]) && $_GET[$param]!=''){
			$aux = explode('-',$_GET[$param]);
			$l = end($aux);

			if(is_numeric($l)){
				$id = clean($l);
			}else{
				return $id;
			}
			return $id;
		}else{
			return $id;
		}
	}



     function upload_largura_varias($path, $larg, $indice, $nome) {
        $file = $_FILES[$nome]['name'][$indice];
        $tamanho = $_FILES[$nome]['size'][$indice];
        $file_tmp_name = $_FILES[$nome]['tmp_name'][$indice];
        if (is_uploaded_file($file_tmp_name)) {
            $mime = $_FILES[$nome]['type'][$indice];
            if (($mime != "")) {
                list($larg_orig, $alt_orig) = getimagesize($file_tmp_name);
                $razao_orig = $larg_orig / $alt_orig;
                $larg = $larg;
                $alt = $larg / $razao_orig;
                $imagem_nova = imagecreatetruecolor($larg, $alt);
                if ($_FILES[$nome]['type'][$indice] == 'image/png') {
                    $imagem = imagecreatefrompng($file_tmp_name);
                } elseif ($_FILES[$nome]['type'][$indice] == 'image/gif' || $_FILES[$nome]['type'][$indice] == 'image/gif') {
                    $imagem = imagecreatefromgif($file_tmp_name);
                } else {
                    $imagem = imagecreatefromjpeg($file_tmp_name);
                } imagecopyresampled($imagem_nova, $imagem, 0, 0, 0, 0, $larg, $alt, $larg_orig, $alt_orig);
                return (imagejpeg($imagem_nova, $path, 100)) ? 1 : 5;
            }
        }
    }

     function upload_tudo_varias($path, $larg, $alt, $indice, $nome) {
        $file = $_FILES[$nome]['name'][$indice];
        $tamanho = $_FILES[$nome]['size'][$indice];
        $file_tmp_name = $_FILES[$nome]['tmp_name'][$indice];
        if (is_uploaded_file($file_tmp_name)) {
            $mime = $_FILES[$nome]['type'][$indice];
            if (($mime != "")) {
                list($larg_orig, $alt_orig) = getimagesize($file_tmp_name);
                $imagem_nova = imagecreatetruecolor($larg, $alt);
                if ($_FILES[$nome]['type'][$indice] == 'image/png') {
                    $imagem = imagecreatefrompng($file_tmp_name);
                } elseif ($_FILES[$nome]['type'][$indice] == 'image/gif' || $_FILES[$nome]['type'][$indice] == 'image/gif') {
                    $imagem = imagecreatefromgif($file_tmp_name);
                } else {
                    $imagem = imagecreatefromjpeg($file_tmp_name);
                } imagecopyresampled($imagem_nova, $imagem, 0, 0, 0, 0, $larg, $alt, $larg_orig, $alt_orig);
                return (imagejpeg($imagem_nova, $path, 100)) ? 1 : 5;
            }
        }
    }
    
     function recorta_imagem($pasta) {
        define('UPLOAD_DIR', '../../imagem/'.$pasta);
        $img = $_POST['image'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = UPLOAD_DIR . uniqid() . '.jpg';
        $success = file_put_contents($file, $data);
        return $success;
    }

?>