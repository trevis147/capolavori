<?php   include('config.php');
		
	$cont=0;
		$q = Query('SELECT * FROM tbl_noticias',0);
		while($r = mysqli_fetch_assoc($q)){
			 Query("INSERT into novidade(Titulo,Texto,Resumo,Imagem,Data,Url,Ativo) VALUES ('".utf8_decode($r['titulo'])."','".utf8_decode($r['texto'])."','".utf8_decode($r['resumo'])."','".$r['foto']."','".$r['data']."','".$r['link']."',1)");
       
			 $cont++;      
		}  


		echo $cont;
		exit;  

   