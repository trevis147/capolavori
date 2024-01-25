<?php

require_once('config.php');

if (isset($_POST['tabela']) && $_POST['tabela'] != '') {
    
    $SQL_ativa = Query("SELECT * FROM `".$_POST['tabela']."` WHERE `".ucfirst($_POST['tabela'])."` = '" . $_POST['var'] . "'",0);
    $Ativa = mysqli_fetch_assoc($SQL_ativa);

    if ($Ativa['Ativo'] == '0') {
        

        if($_POST['tabela']=='compra_de_saldo'){   
        	$q_pedido = Query('SELECT * FROM compra_de_saldo WHERE Compra_de_saldo = '.$_POST['var'].'',0);
        	if(mysqli_num_rows($q_pedido) > 0){
        		$r_pedido = mysqli_fetch_assoc($q_pedido);
                $q_saldo_pedido = Query('SELECT Saldo,Quantidade,Valor FROM saldo WHERE Saldo = '.$r_pedido['Saldo'].'');
                if(mysqli_num_rows($q_saldo_pedido) > 0){
                   $r_saldo_pedido = mysqli_fetch_assoc($q_saldo_pedido);
                      
                   Query('INSERT INTO saldo_adicionado(Titulo,Saldo,Compra_de_saldo,User,Valor,Quantidade,Data,Ativo) VALUES(NOW(),'.$r_saldo_pedido['Saldo'].','.$r_pedido['Compra_de_saldo'].','.$r_pedido['User'].',"'.$r_saldo_pedido['Valor'].'","'.$r_saldo_pedido['Quantidade'].'",NOW(),1)');
                              
                    $q_user = Query('SELECT * FROM user WHERE User = '.$r_pedido['User'].'',0);
                    if(mysqli_num_rows($q_user) > 0){
                        $r_user = mysqli_fetch_assoc($q_user);
                        $r_user['Saldo'] = $r_user['Saldo'] + $r_saldo_pedido['Quantidade'];
                        Query('UPDATE user SET Saldo = '.$r_user['Saldo'].' WHERE User = '.$r_pedido['User'].'');
                        Query('UPDATE compra_de_saldo SET Status_da_compra = 2 WHERE Compra_de_saldo = '.$r_pedido['Compra_de_saldo'].'');
                        Query("UPDATE `".$_POST['tabela']."` SET Ativo = '1' WHERE  `".ucfirst($_POST['tabela'])."` = '".$_POST['var']."' ",0);
                    }
                }
                // $conteudo = '<tr>
                // <td style="font-size: 17px; font-family: sans-serif;">
                //     Olá '.$r_user['Titulo'].', a doação que foi realizada foi recebida e você ganhou '.$Ativa['Pontos'].' pontos, tendo agora um total de '.$pts.' pontos.<br>
                //     Confira os produtos disponíveis para troca em sua <a href="'.$Config['UrlSite'].'login">área do cliente</a> usando seu login e senha.<br>
                //     <b>Atenciosamente Equipe EuRecicloSorocaba</b>
                //     </td>  
                // </tr>';     

                // $config_smtp = Query('SELECT * FROM configuracao_smtp WHERE Ativo = 1 ORDER BY Configuracao_smtp DESC LIMIT 1',1);
                // $destinatarios = $config_smtp['Destinatarios'];

                // $dest_arr = explode(',',$destinatarios);
                // foreach($dest_arr as $key => $value){       
                //     envia_email('EuRecicloSorocaba - Doação Recebida',$conteudo,$r_user['Email']);
                // } 
        	}       
        }else{
            Query("UPDATE `".$_POST['tabela']."` SET Ativo = '1' WHERE  `".ucfirst($_POST['tabela'])."` = '".$_POST['var']."' ",0);
        }

        echo '1';
        exit;
    }else{
        if($_POST['tabela']=='compra_de_saldo'){   
            echo '1';
            exit;
        }else{
            Query("UPDATE `".$_POST['tabela']."` SET Ativo = '0' WHERE  `".ucfirst($_POST['tabela'])."` = '".$_POST['var']."' ",0);
            echo '2';            
            exit;
        }
    }
}



