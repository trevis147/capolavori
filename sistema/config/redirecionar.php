<?php


include "config.php";


    if($_POST) {

        if(!isset($_POST["login"]) || $_POST["login"] == "" ||  !isset($_POST["senha"]) || $_POST["senha"] == "") {

            $Erro = "Informe login e senha.";

        } else {
   
            $login = clean($_POST["login"]);
            $senha = clean($_POST["senha"]);

 
            $DadosUsuario = Query("SELECT * FROM usuario WHERE  Email = '".$login."' AND Senha = MD5('".$senha."');", 1);  
            
            if(isset($DadosUsuario) && $DadosUsuario != "" && isset($DadosUsuario["Usuario"]) && is_numeric($DadosUsuario["Usuario"])) {

                

                $_SESSION[$Config["PrefixoSessao"]."IdUsuario"] = $DadosUsuario["Usuario"];

                $_SESSION[$Config["PrefixoSessao"]."Nome"] = $DadosUsuario["Titulo"];

                $_SESSION['Nivel'] = $DadosUsuario["Nivel_usuario"]; 
              //  $_SESSION[$Config["PrefixoSessao"]."Layout"] = $DadosUsuario["Layout"];

 

                $_SESSION['id'] = $DadosUsuario['Usuario'];

    			$_SESSION['email'] = $DadosUsuario['Email'];

                if(isset($Config["Backlog"]) && $Config["Backlog"]==1){  
                        Query('INSERT INTO historico_uso_sistema(Titulo,Data_hora,Acao,Usuario) VALUES("Login - '.$DadosUsuario["Usuario"].'",NOW(),"Login",'.$DadosUsuario["Usuario"].')');
                }



              //  print_r($_SESSION);
             //   exit;

                echo 1;
                exit;
                //header("Location: ".$Config["Url"]."index"); exit;

            } else {

                $Erro = "Login e senha ou senha não localizados.";  

            }

        }

    }



    echo '0'

?>