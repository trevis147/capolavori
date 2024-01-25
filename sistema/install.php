<?php   include('config/config.php');
        $login = 0; 

        Query("CREATE TABLE IF NOT EXISTS `historico_uso_sistema` (
        
                    `Historico_uso_sistema` int(11) NOT NULL AUTO_INCREMENT,

                    `Titulo` varchar(120) NOT NULL,

                    `Data_hora` varchar(120) NOT NULL,

                    `Tabela` varchar(120) NOT NULL,

                    `Acao` varchar(120) NOT NULL,

                    `Registro` varchar(120) NOT NULL,

                    `Usuario` int(11) NOT NULL,

                    PRIMARY KEY (`Historico_uso_sistema`))",0);


        Query("CREATE TABLE IF NOT EXISTS `usuario` ( 

                    `Usuario` int(11) NOT NULL AUTO_INCREMENT,

                    `Titulo` varchar(120) NOT NULL,

                    `Email` varchar(200) NOT NULL,

                    `Senha` varchar(200) NOT NULL,

                    `Nivel_usuario` int(11) NOT NULL,
                    
                    `Data_hora_ultimo_login` varchar(200) NOT NULL,

                    PRIMARY KEY (`Usuario`))",0);

        $q = Query('SELECT * FROM usuario WHERE Email = "lucas@makeweb.com.br"',0);

        $user = 0;
        if(mysqli_num_rows($q)==0){
            $user =  Insert('INSERT INTO usuario(Titulo,Nivel_usuario,Data_hora_ultimo_login,Email,Senha) values("admin",1,NOW(),"lucas@makeweb.com.br",MD5("Make#7735*"))');

            $_SESSION[$Config["PrefixoSessao"]."IdUsuario"] = $user;
            $_SESSION[$Config["PrefixoSessao"]."Nome"] = "admin";
            $_SESSION['id'] = $user;
            $_SESSION['email'] = "lucas@makeweb.com.br";
            $login = 1;
        }   

        /*Procedimento de rotina para criar tabelas que possam estar faltando*/
        Query("CREATE TABLE IF NOT EXISTS `galerias_fotos` (

                    `Galerias_fotos` int(11) NOT NULL AUTO_INCREMENT,

                    `Tipo_pag` int(11) NOT NULL,

                    `Foto` varchar(120) NOT NULL,

                    `Galerias` int(11) NOT NULL,

                    `Titulo` varchar(120) NOT NULL,

                    `Texto` text NOT NULL,

                    PRIMARY KEY (`Galerias_fotos`))",0);
 

        Query("CREATE TABLE IF NOT EXISTS `nivel_usuario` (    

                    `Nivel_usuario` int(11) NOT NULL AUTO_INCREMENT,

                    `Titulo` varchar(120) NOT NULL,

                    `Url` varchar(200) NOT NULL,

                    `Destaque` INTEGER DEFAULT 0,

                    `Ativo` INTEGER DEFAULT 0,    

                    PRIMARY KEY (`Nivel_usuario`))",0);

        $q_1 = Query('SELECT * FROM nivel_usuario WHERE Nivel_usuario = 1');
        $q_2 = Query('SELECT * FROM nivel_usuario WHERE Nivel_usuario = 2');
        
        if(mysqli_num_rows($q_1)==0){
            Query('Insert into nivel_usuario(Nivel_usuario,Titulo,Url,Destaque,Ativo) values(1,Administrativo","administrativo",1,1)');
        } 

        if(mysqli_num_rows($q_2)==0){
            Query('Insert into nivel_usuario(Nivel_usuario,Titulo,Url,Destaque,Ativo) values(2,"Comum","comum",1,1)');
        }
      
         
                            foreach($Gerenciamentos as $table => $n_i){

                                $result_test = '';
                                $query_test_exists = "SELECT * FROM ".$table."";
                                $result_test = Query($query_test_exists,0);

                                /*Se não houver tabela entra em um processo custoso N², na primeira iteracao N³*/
                                if(empty($result_test)) {
                                    $query = "CREATE TABLE ".$table." (".ucfirst($table)." int AUTO_INCREMENT,";
                                    foreach($Gerenciamentos[$table] as $campo => $n_i_2){

                                    if($campo!='Galeria'){

                                        if($Gerenciamentos[$table][$campo][1]!='KID'){
                                            $query .= "".$campo." ";
                                            $flag = -1;
                                        }

                                        foreach($Gerenciamentos[$table][$campo] as $n_v_3 => $atributo){

                                        if($flag==2){
                                            break;
                                        }

                                        if($flag==1){
                                            $query .= "".$atributo."), ";
                                            $flag = 2;
                                        }                    

                                        if($flag==0){
                                            if($atributo=='VARCHAR'){
                                                $query .= "".$atributo."(";
                                                $flag = 1;
                                            }else if($atributo=='IMAGEM'){
                                                $query .= " VARCHAR(120), ";
                                                $flag = 2; 
                                            }else if($atributo=='TEXT'){
                                                $query .= " ".$atributo.", ";
                                                $flag = 2;
                                            }else if($atributo=='RESUMO'){
                                                $query .= " TEXT, ";
                                                $flag = 2;
                                            }else if($atributo=='FILE'){
                                                $query .= " VARCHAR(220), ";
                                                $flag = 2; 
                                            }else if($atributo=='DATE'){
                                                $query .= " DATE, ";
                                                $flag = 2; 
                                            }else if($atributo=='KID'){
                                                $flag = 2;
                                                //exit;
                                            }else{ // No caso do else é uma chave que esta vindo de outra table portanto é int
                                                $query .= " INT, ";
                                                $flag = 2;
                                            }
                                        }



                                        if($flag==-1){

                                            $flag++;

                                        }    



                                    }

                                  }

                               

                                }



                                $query .= "Url VARCHAR(220),";

                                $query .= "Destaque INTEGER DEFAULT 0,";

                                $query .= "Ativo INTEGER DEFAULT 0,";

                                $query .= "PRIMARY KEY(".ucfirst($table)."))";

                                Query($query,0);

                           }

                            $sql = 'Select Menu_sistema from menu_sistema where Titulo = "'.$table.'"';
                            $query = Query($sql,0);

                            if(mysqli_num_rows($query) == 0){
                                $query_menu = "Insert into menu_sistema(Titulo,Rotulo,Grupo_menu,Ordem,Destaque,Ativo) values('".$table."','".$table."',0,0,0,1)";
                                Query($query_menu,0);
                            }

                        }

                        if($login){
                            unlink('install.php');
                            header("Location: ".$Config['Url']);
                        }



 