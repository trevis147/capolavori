<?php



	



	if(!isset($Autentica))

		$Autentica = 0;

	

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

	

	EstaLogado();

	

	function Conectar($Servidor, $Usuario, $Senha, $Banco) {

		$Conexao = mysql_connect($Servidor,$Usuario,$Senha) or die("ERRO: Configuração inválida de banco de dados.");

		mysql_select_db($Banco, $Conexao) or die("ERRO: Banco não encontrado");

		mysql_set_charset("utf8");

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

		$Dados = mysql_query($Sql, $Conexao);

		

		if(isset($DEBUG) && $DEBUG == 1) {

			$SQLDEBUG[] = $Sql;

		}

		

		if($Fetch == 1) {

			$Retorno = mysql_fetch_assoc($Dados);

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

			$Sql .= $v.",";

		}

		$Sql = substr($Sql, 0, -1);

		$Sql .= " FROM ".strtolower($From);

		if($Where != NULL) {

			$Sql .= " Where ".$Where[0].'='.$Where[1].' ';

		}


		if($Ordem != NULL) {

			$Sql .= " ORDER BY ".ucfirst(strtolower($From));

		}

		

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



?>