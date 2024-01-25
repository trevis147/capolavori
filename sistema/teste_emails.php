<?php         						
        $host = "pop.makeweb.com.br"; //aqui você deve informar o seu servidor de Email, pode ser imap.domínio ou pop.domínio 
        $usuario = "lucas@desenvolvimentomw.com.br";
        $senha = "Make#luc7735";
        $port = 143;

        $caixaDeCorreio = imap_open("{".$host.":".$port."/novalidate-cert}INBOX", $usuario, $senha);
         
        if(!$caixaDeCorreio)
        {
                print_r(imap_errors()); 
        }
        else
        {
                /*
                $listaPastas = imap_getmailboxes($caixaDeCorreio, "{".$host."}", "*");
                if (is_array($listaPastas))
                {
                        // Preparando a listagem de pastas
                        echo ("<p>Listando as pastas do seu IMAP</p>\n");
                        foreach ($listaPastas as $chavePastas => $valorPastas)
                        {
                                echo "<p><b>".str_replace("{".$host."}", "", $valorPastas->name)."</b><br>\n";
         
                                $host2 = str_replace("}", ":143/novalidate-cert}", $valorPastas->name);
         
                                $caixaDeCorreio1 = imap_open($host2, $usuario, $senha);
                                if(!$caixaDeCorreio1)
                                {
                                        echo "Erro ao tentar listar a pasta ".$valorPastas->name;
                                        print_r(imap_errors());
                                }
                                else
                                {
                                        $check = imap_mailboxmsginfo($caixaDeCorreio1);
                                        if($check)
                                        {
                                                // Mostrando os detalhes de cada pasta
                                                echo "Total de mensagens: <i>".$check->Nmsgs."</i><br>\n";
                                                echo "Mensagens nao lidas: <i>".$check->Unread."</i><br>\n";
                                                echo "Tamanho total: <i>".$check->Size." Bytes</i><br>\n";
                                                echo "</p>\n";
                                        }
                                        else
                                        {
                                                echo "Erro ao obter os detalhes das pastas:<br>".imap_last_error();
                                        }
                                        $caixaDeCorreio1 = imap_close($caixaDeCorreio1);
                                }
         
                        }
                }
                else
                {
                        echo "Nao consegui obter a lista de pastas:<br>".imap_last_error();
                }
                */

                $total_de_mensagens = imap_num_msg($caixaDeCorreio);
            	if ($total_de_mensagens > 0) {
                	for ($mensagem = 1; $mensagem <= $total_de_mensagens; $mensagem++) {
                   
                        $header = imap_headerinfo($caixaDeCorreio,$mensagem);
                        
                        if($header->message_id =='<25bb12df6463b86e195b4e761ccbe4ea@grupomake.com.br>'){           
                            print_r($header);

                            $body_2 = imap_fetchbody($caixaDeCorreio, $mensagem, 2); 
                            echo $body_2;
                        }

                    /*
                     *  o terceiro parametro pode ser
                     *  0=> retorna o body da mensagem com o texto que o servidor recebe
                     *  1=> retorna somente o conteudo da mensagem em plain-text
                     *  2=> retorna o conteudo da mensagem em html
                     */
                    
                   /* echo "<hr />";
                    $body_1 = ( imap_fetchbody($caixaDeCorreio, $mensagem, 1) );
                    echo $body_1;
                    echo "<hr />";
                    $body_0 = ( imap_fetchbody($caixaDeCorreio, $mensagem, 0) );
                    echo $body_0;
                    echo "<hr />";*/

                    // deixei comentando pra não dar problema e excluir todos seus e-mails
                    
                    //imap_delete($caixaDeCorreio, $mensagem);
                    //imap_expunge($caixaDeCorreio);
                }
            }

                $caixaDeCorreio = imap_close($caixaDeCorreio);
        }

?>