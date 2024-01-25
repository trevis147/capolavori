<?php   include('config/config.php'); 

		$draw = 0;
		$start = 0;
		$length = 0;  
		$table = ''; 
		$search = '';

		$order_column = '';
		$order_method = 'DESC';


		if(isset($_GET['search']['regex']) && $_GET['search']['regex']){
			$search = $_GET['search']['value'];
		}else{
			echo 0;    
			exit;
		} 

		if(isset($_GET['draw']) && is_numeric($_GET['draw'])){
			$draw = $_GET['draw'];
		}else{
			echo 0;    
			exit;
		} 
 
		if(isset($_GET['start']) && is_numeric($_GET['start'])){
			$start = $_GET['start'];
		}else{
			echo 0;
			exit;
		} 

		if(isset($_GET['length']) && is_numeric($_GET['length'])){
			$length = $_GET['length'];
		}else{
			echo 0;
			exit;
		} 

		//coleta a tabela
		/*if(isset($_GET[1]) && $_GET[1]!=''){
			$table = $_GET[1];
		}else{
			echo 0;
			exit;
		} */

		$table  = 'usuario';

		
		if(isset($_GET['order'][0]['column']) && is_numeric($_GET['order'][0]['column'])){
			if($_GET['order'][0]['column']==1){
				$order_column = ucfirst($table);
				$order_method = $_GET['order'][0]['dir'];
			}else if($_GET['order'][0]['column']==2){
				$order_column = 'Titulo';
				$order_method = $_GET['order'][0]['dir'];
			}else{
				$order_column = ucfirst($table);
				$order_method = 'DESC';
			} 
		}else{
			$order_column = ucfirst($table);
			$order_method = 'DESC';
		} 

	
		//echo "SELECT * FROM $table ORDER BY ucfirst($table) DESC";

		if($especialista!=''){
			if($search!=''){
				$q = Query("SELECT * FROM $table WHERE Titulo LIKE '%".$search."%' AND ".$especialista." ORDER BY ".$order_column." ".$order_method."",0);
				$count = mysqli_num_rows($q);
				$q_reg = Query("SELECT * FROM $table  WHERE Titulo LIKE '%".$search."%' AND ".$especialista." ORDER BY ".$order_column." ".$order_method." LIMIT $start,$length",0);
			}else{
				$q = Query("SELECT * FROM $table WHERE ".$especialista." ORDER BY ".$order_column." ".$order_method."",0);
				$count = mysqli_num_rows($q);
				$q_reg = Query("SELECT * FROM $table WHERE ".$especialista." ORDER BY ".$order_column." ".$order_method." LIMIT $start,$length",0);
			}
		}else{
			if($search!=''){
				$q = Query("SELECT * FROM $table WHERE Titulo LIKE '%".$search."%'  ORDER BY ".$order_column." ".$order_method."",0);
				$count = mysqli_num_rows($q);
				$q_reg = Query("SELECT * FROM $table  WHERE Titulo LIKE '%".$search."%' ORDER BY ".$order_column." ".$order_method." LIMIT $start,$length",0);
			}else{
				$q = Query("SELECT * FROM $table ORDER BY ".$order_column." ".$order_method."",0);
				$count = mysqli_num_rows($q);
				$q_reg = Query("SELECT * FROM $table ORDER BY ".$order_column." ".$order_method." LIMIT $start,$length",0);
			}
		}


        
		   

		echo '{ 
		  "draw": '.$draw.', 
		  "recordsTotal": '.$count.',
		  "recordsFiltered": '.$count.',
		  "data": [   
		'; 
      


   		$flag = 1;
		while($registro = mysqli_fetch_assoc($q_reg)){

			$id = $registro[ucfirst($table)];
			$titulo = $registro['Titulo'];
			$email = $registro['Email'];
			$nivel = $registro['Nivel_usuario']; 

			if($flag==0){
				echo ',';
			}else{   
				$flag = 0;	
			}


  
				echo ' [
			      "'.$id.'",
			      "'.$titulo.'",
			      "'.get_nivel($nivel).'",
			      "'.$email.'",';

			      echo '"<a href=\''.$Config['UrlSite'].'sistema/gerenciar-usuario.php?1='.$id.'\' class=\'btn noleftmargin small-padding\'><img src=\''.$Config['UrlSite'].'sistema/img/editar_24.png\'></a>"';
			      

			      
			    echo ']';  
			

		}

		echo ']}';
		exit;
