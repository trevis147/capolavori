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
		if(isset($_GET[1]) && $_GET[1]!=''){
			$table = $_GET[1];
		}else{
			echo 0;
			exit;
		} 

		$especialista  = '';
		$especialista_id = 0;
		$chave = '';
		//coleta especialista
		if(isset($_GET[2]) && is_numeric($_GET[2])){
           foreach($Gerenciamentos[$table] as $n_v_3 => $v){
                if($v[1]=='KEY'){ 
                    $chave = $v[2];
                    break;   
                } 
            }
            $especialista = ucfirst(strtolower($chave)).' = '.$_GET[2];
            $especialista_id = $_GET[2];
		}

		if(isset($_GET['order'][0]['column']) && is_numeric($_GET['order'][0]['column'])){
			if($_GET['order'][0]['column']==1){
				$order_column = ucfirst($table);
				$order_method = $_GET['order'][0]['dir'];
			}else if($_GET['order'][0]['column']==2){
				$order_column = 'Titulo';
				$order_method = $_GET['order'][0]['dir'];
			}else if($_GET['order'][0]['column']==3){
				$order_column = 'Ordem';
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

			if($flag==0){
				echo ',';
			}else{   
				$flag = 0;	
			}


			if($registro['Ativo']){
				$ativo = '<img id=\'a_'.$id.'\' class=\'at  at_'.$table.'\' src=\''.$Config['Url'].'img/ativar_24.png\'>';
			}else{
				$ativo = '<img id=\'a_'.$id.'\' class=\'at  at_'.$table.'\' src=\''.$Config['Url'].'img/desativar_24.png\'>';
			}
  

			if($registro['Destaque']){
				$destaque = '<img id=\'d_'.$id.'\' class=\'des  des_'.$table.'\' src=\''.$Config['Url'].'img/ativar_24.png\'>';
			}else{
				$destaque = '<img id=\'d_'.$id.'\' class=\'des  des_'.$table.'\' src=\''.$Config['Url'].'img/desativar_24.png\'>';
			}   

    
				echo ' {
					"DT_RowId": "tr'.$id.'",
					"DT_RowClass": "ui-sortable-handle odd",
		            "DT_RowData": { 
		                "pkey": '.$id.'
		            },
				  "checkbox" : "<input class=\'check_delete\' type=\'checkbox\' value=\''.$id.'\'>", 
			      "'.$table.'" : "'.$id.'", 
			      "titulo" : "'.$titulo.'",';

			     	if($table=='deposito'){
                  		echo '"quantidade" :" '.$registro['Quantidade'].'",'; 
                  		echo '"codigo" :" '.$registro['Codigo'].'",'; 
                  		echo '"data_realizado" :" '.formata_data($registro['Data_realizado']).'",'; 
                  	}else if($table=='troca'){
                  		//echo '"quantidade" :" '.$registro['Quantidade'].'",'; 
                  		echo '"status_troca" :" '.get('status_troca',$registro['Status_troca']).'",'; 
                  		echo '"pontos" :" '.$registro['Pontos'].'",'; 
                  		echo '"data_solicitado" :" '.formata_data($registro['Data_solicitado']).'",'; 
                  	}else if($table=='log'){   
                  		echo '"data" :" '.formata_data($registro['Data']).'",'; 
                  		echo '"referencia" :" '.$registro['Referencia'].'",'; 
                  		echo '"tipo" :" '.$registro['Tipo'].'",'; 
                  	}



			        if($table=='solucao'){
                  		echo '"ordem" :" '.$registro['Ordem'].'",'; 
                  	}
              
			      	foreach($Gerenciamentos[$table] as $n_v_3 => $v){ 
						if($v[1]=='KID'){
                            echo '"'.strtolower($n_v_3).'" : "<a href=\''.$Config["Url"].'registros.php?1='.strtolower($v[2]).'&2='.$id.'\' class=\'btn noleftmargin small-padding\'><img src=\''.$Config["Url"].'img/editar_24.png\' /></a>",';                                                                    
                  		}else if($v[4]=='FLAG'){
                  			if($v[5]==""){
                  				echo '"'.strtolower($n_v_3).'" : "'.$registro[$n_v_3].'",'; 
                  			}else{
								$q_attr = Query('SELECT * FROM '.strtolower($n_v_3).' WHERE '.ucfirst(strtolower($n_v_3)).' = '.$registro[$n_v_3].'',0);

								//echo 'SELECT * FROM '.strtolower($n_v_3).' WHERE '.ucfirst(strtolower($n_v_3)).' = '.$registro[$n_v_3].'';
								//exit;

								if(@mysqli_num_rows($q_attr) > 0){
									$attr = mysqli_fetch_assoc($q_attr);
									echo '"'.strtolower($n_v_3).'" : "'.$attr['Titulo'].'",';
								}else{
									echo '"'.strtolower($n_v_3).'" : "Não identificado",';
								}
                  			}
                  		} 
                  	} 


			      echo '"destaque" : "'.$destaque.'", 
			      		"ativo" : "'.$ativo.'",'; 	

			      if($especialista_id!=''){
			      	echo '"editar" : "<a href=\''.$Config['UrlSite'].'sistema/gerenciar.php?1='.$table.'&2='.$id.'&3='.$especialista_id.'\' class=\'btn noleftmargin small-padding\'><img src=\''.$Config['UrlSite'].'sistema/img/editar_24.png\'></a>"';
			      }else{
			      	echo '"editar" : "<a href=\''.$Config['UrlSite'].'sistema/gerenciar.php?1='.$table.'&2='.$id.'\' class=\'btn noleftmargin small-padding\'><img src=\''.$Config['UrlSite'].'sistema/img/editar_24.png\'></a>"';
			      }

			    echo '}';  
			
		}

		echo ']}';
		exit;
