<?php session_start();
      require_once('../config/config.php');

     if(!isset($_SESSION['Sis545IdUsuario'])) {
	    session_destroy();
		echo 0;
		exit;
	 }

	 $id = 0;
	 $table = '';

	if(isset($_POST['id']) && is_numeric($_POST['id'])){
		$id = $_POST['id'];
	}else{
		echo 0;
		exit;
	}

	if(isset($_POST['table']) && $_POST['table']!=''){
		$table = clean($_POST['table']);
	}else{
		echo 0;
		exit;
	}

	
	Query('DELETE FROM '.$table.' WHERE '.ucfirst($table).' = '.$id.'',0); 
	
	if(isset($Config["Backlog"]) && $Config["Backlog"]==1){      
		Query('INSERT INTO historico_uso_sistema(Titulo,Data_hora,Acao,Usuario,Tabela,Registro) VALUES("DELETE - '.$_SESSION['Sis545IdUsuario'].'",NOW(),"DELETE",'.$_SESSION['Sis545IdUsuario'].',"'.$table.'","'.$id.'")');
	}

	echo 1;
	exit;