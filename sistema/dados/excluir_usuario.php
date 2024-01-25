<?php session_start();
      require_once('../config/config.php');


    if(isset($_POST['usuario']) && $_POST['usuario']!=''){   

        $id = clean($_POST['usuario']); 

        if(isset($_SESSION['id']) && (($id==$_SESSION['id'])  || ($_SESSION['Nivel']==1))){
            $user_q = Query('SELECT * FROM usuario WHERE Usuario = '.$id.'');
            if(mysqli_num_rows($user_q) > 0){
                $user = mysqli_fetch_assoc($user_q);
                Query('DELETE FROM usuario WHERE Usuario = '.$user['Usuario'].'');
                echo 1;
                exit;
            //usuario nao identificado
            }else{
                echo 3;
                exit;
            }
        //Não tem permissão para editar o usuario
        }else{
            echo 2;
            exit;
        }
       //erro de parametro 
    }else{
    	echo 0;
    	exit;
    }