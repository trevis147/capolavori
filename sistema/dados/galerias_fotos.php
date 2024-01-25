<?php

session_start();
//require_once('../config/classes.php');
//require_once('../config/instancias.php');
require_once('../config/config.php');


$imagem = '../../imagem/';
if(!file_exists($imagem)) {// testo se a pasta existe
    mkdir($imagem,0777);
} 


$caminho = '../../imagem/galerias_fotos/';
$caminho2 = '../../imagem/galerias_fotos/thumbnail/';
$caminho3 = '../../imagem/galerias_fotos/media/';

			

			if(!file_exists($caminho)) {// testo se a pasta existe
            	mkdir($caminho,0777);
       		} 
			
			if(!file_exists($caminho2)) {// testo se a pasta existe
            	mkdir($caminho2,0777);
       		} 

			if(!file_exists($caminho3)) {// testo se a pasta existe
            	mkdir($caminho3,0777);
       		} 

          $name = explode('.',$_FILES["file"]["name"]);
          $nome_novo = md5($name[0]);
          $nome_novo = $nome_novo.'.'.$name[1];

if(isset($_GET[1])  && is_numeric($_GET[1])  &&  isset($_GET[2])  && is_numeric($_GET[2])) {   
  $registro = clean($_GET[1]); 
  $tipo_pag = clean($_GET[2]); 

  $alt  = clean($_GET[3]); 
  $larg = clean($_GET[4]); 

  if(isset($_FILES["file"]["name"]) && $_FILES["file"]["name"] != '') {  
      $id = Insert('Insert into galerias_fotos(Foto,Galerias,Tipo_pag,Titulo,Texto) values("'.$nome_novo.'",'.$registro.','.$tipo_pag.',"","")',0);
     
    // echo 'Insert into galerias_fotos(Foto,Galerias,Tipo_pag,Titulo,Texto) values("'.$nome_novo.'",'.$registro.','.$tipo_pag.',"","")';

      upload_altura($_FILES["file"], $caminho3 .$nome_novo, 260);
     	upload_larg_alt($_FILES["file"], $caminho2 .$nome_novo, 120, 120);

      if($alt==0 && $larg==0){
        upload_arquivo($nome_novo,$_FILES["file"]['tmp_name'], $caminho);
      }else{
        upload_larg_alt($_FILES["file"], $caminho.$nome_novo,$larg,$alt);        
      }
      
      echo $id; 
      /*$obj['id'] = $id;
      $obj['name'] = $nome_novo; 
      $obj['size'] = filesize("../../imagem/galerias_fotos/thumbnail/".$nome_novo);
      $obj['titulo'] = '';
      $obj['texto'] = '';
      $result[] = $obj;

      header('Content-Type: application/json');

      if ($result==NULL) {
        echo 0;
      }else{
        echo json_encode($result);
      }*/
  }
}