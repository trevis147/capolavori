<?php

session_start();
require_once('config.php');
include "../WideImage/WideImage.php";
//require_once('instancias.php');

//print_r($_GET);

if (isset($_GET[1])  && is_numeric($_GET[1])  &&  isset($_GET[2])  && is_numeric($_GET[2])) {

	//echo  "Galerias_fotos = '".$_SESSION['Pagina']."' and Tipo_pag = '".$_SESSION['TipoPagina']."'";
	//exit;
    $tabela = clean($_GET[1]); 

   // echo "Select * from galerias_fotos where Galerias = '".$tabela."' and Tipo_pag = '".$_GET[2]."' order by galerias_fotos ASC";

    $SQL = Query("Select * from galerias_fotos where Galerias = '".$tabela."' and Tipo_pag = '".$_GET[2]."' order by galerias_fotos ASC",0);
    while($image = mysqli_fetch_assoc($SQL)) {

       if(file_exists("../../imagem/galerias_fotos/" . $image['Foto'])){
        $obj['id'] = $image['Galerias_fotos'];
        $obj['name'] = $image['Foto'];


        if(!file_exists("../../imagem/galerias_fotos/thumbnail/" . $image['Foto'])){
            $fonte = "../../imagem/galerias_fotos/" . $image['Foto']; 
            $NovaImagem = WideImage::load($fonte);
            $resized = $NovaImagem->resize(120,120,'fill');
            $resized->saveToFile("../../imagem/galerias_fotos/thumbnail/" . $image['Foto']);
        }
   

        $obj['size'] = filesize("../../imagem/galerias_fotos/thumbnail/" . $image['Foto']);
        $obj['titulo'] = $image['Titulo'];
        $obj['texto'] = $image['Texto'];
        $result[] = $obj;
      }else{
        //echo 'Não existe = ../../imagens/veiculo/1200/'.$image['Foto'];
       // Query('DELETE from galerias_fotos where Galerias_fotos ='.$image['Galerias_fotos'].'');
      }


    }  
    header('Content-Type: application/json');

    if ($result == NULL) {
        echo 0;
    } else {
        echo json_encode($result);
    }
}