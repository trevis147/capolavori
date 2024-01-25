<?php   

	$Gerenciamentos = array(           

		"menu_sistema" => array(
			"Titulo" => array(NULL,"VARCHAR",200, "NOT NULL"),
			"Grupo_menu" => array(NULL,"grupo_menu",1,"NOT NULL","FLAG","grupo_menu"),
			"Rotulo" => array(NULL,"VARCHAR",200, "NOT NULL"),
			"Ordem"  => array(NULL,"INT",10),
			"Icone"  => array(NULL,"VARCHAR",200, "NOT NULL")
		),      
             
		"grupo_menu" => array(
			"Titulo" => array(NULL,"VARCHAR",200, "NOT NULL")
		),  

		"download_home" => array(
			"Titulo"  => array(NULL,"VARCHAR",200, "NOT NULL"),
			"Arquivo" => array(NULL, "FILE", "download_home", "Envie um arquivo para o download", array(array(1900,1425), array(380,285)))
		),  
        
		"configuracao_smtp" => array(
			"Titulo" 			=> array(NULL,"VARCHAR",200, "NOT NULL"),
			"Email_sender" 		=> array(NULL,"VARCHAR",200, "NOT NULL"),
			"Senha_sender" 		=> array(NULL,"VARCHAR",200, "NOT NULL"),
			"Destinatarios"  	=> array(NULL,"RESUMO", 1)
		),

		"dados_da_empresa" => array(
			"Titulo" 			=> array(NULL,"VARCHAR",200, "NOT NULL"),
			"Texto_cookie"  	=> array(NULL,"RESUMO", 1),
			"Instagram"  	=> array(NULL,"RESUMO", 1),
			"Whatsapp"  	=> array(NULL,"RESUMO", 1),
			"Linkedin"  	=> array(NULL,"RESUMO", 1),
			"Endereco"  	=> array(NULL,"RESUMO", 1),
			"Email" 			=> array(NULL,"VARCHAR",200, "NOT NULL"),
			"Telefone" 			=> array(NULL,"VARCHAR",200, "NOT NULL")
		),

		"newsletter" => array(
			"Titulo" 			=> array(NULL,"VARCHAR",200, "NOT NULL"),
			"Email" 			=> array(NULL,"VARCHAR",200, "NOT NULL")
		),

		/*Home*/
		"imagem_home" => array(        
			"Titulo"           => array(NULL,"VARCHAR",120,"NOT NULL"),
			"Ordem"  => array(NULL,"INT",10),
			"Imagem"           => array(NULL, "IMAGEM", "imagem_home", "<p class='alert alert-info' style='text-align:center;'>Tamanho <strong>recomendado</strong>: <strong>400 x 225</strong> </p>", array(array(400,225)))

		),

		"bem_vindo" => array(
			"Titulo"    => array(NULL,"VARCHAR",200, "NOT NULL"),
			"Texto"    => array(NULL,"TEXT", 1)
		),  


		"introducao" => array(
			"Titulo"    => array(NULL,"VARCHAR",200, "NOT NULL"),
			"Texto"    => array(NULL,"TEXT", 1),
			"Imagem"           => array(NULL, "IMAGEM", "introducao", "<p class='alert alert-info' style='text-align:center;'>Tamanho <strong>recomendado</strong>: <strong>400 x 275</strong> </p>", array(array(400,275)))
		),  
 
		"quem_somos" => array(
			"Titulo"    => array(NULL,"VARCHAR",200, "NOT NULL"),
			"Texto"    => array(NULL,"TEXT", 1),
			"Imagem"           => array(NULL, "IMAGEM", "quem_somos", "<p class='alert alert-info' style='text-align:center;'>Tamanho <strong>recomendado</strong>: <strong>400 x 600</strong> </p>", array(array(400,600)))
		),  

		"produto" => array(
			"Titulo"    => array(NULL,"VARCHAR",200, "NOT NULL"),
			"Texto"    => array(NULL,"TEXT", 1),
			"Imagem"           => array(NULL, "IMAGEM", "produto", "<p class='alert alert-info' style='text-align:center;'>Tamanho <strong>recomendado</strong>: <strong>400 x 400</strong> </p>", array(array(400,275)))
		),  

		"fornecedor" => array(
			"Titulo"    => array(NULL,"VARCHAR",200, "NOT NULL"),
			"Ordem"  => array(NULL,"INT",10),
			"Link"    => array(NULL,"Resumo", 1),
			"Imagem"           => array(NULL, "IMAGEM", "fornecedor", "<p class='alert alert-info' style='text-align:center;'>Tamanho <strong>recomendado</strong>: <strong>300 x 300</strong> </p>", array(array(300,300)))
		),  

		"cliente" => array(
			"Titulo"    => array(NULL,"VARCHAR",200, "NOT NULL"),
			"Ordem"  => array(NULL,"INT",10),
			"Link"    => array(NULL,"Resumo", 1),
			"Imagem"           => array(NULL, "IMAGEM", "cliente", "<p class='alert alert-info' style='text-align:center;'>Tamanho <strong>recomendado</strong>: <strong>300 x 300</strong> </p>", array(array(300,300)))
		),  

		"contato_pagina" => array(
			"Titulo"    => array(NULL,"VARCHAR",200, "NOT NULL"),
			"Texto"    => array(NULL,"TEXT", 1)
		),


		"fornecedor_pagina" => array(
			"Titulo"    => array(NULL,"VARCHAR",200, "NOT NULL"),
			"Texto"    => array(NULL,"TEXT", 1)
		),



		"produto_pagina" => array(
			"Titulo"    => array(NULL,"VARCHAR",200, "NOT NULL"),
			"Texto"    => array(NULL,"TEXT", 1)
		),



		"contato" => array(
			"Titulo"      => array(NULL,"VARCHAR",200, "NOT NULL"),
			"Email"       => array(NULL,"VARCHAR",200, "NOT NULL"),
			"Assunto"     => array(NULL,"VARCHAR",200, "NOT NULL"),
			"Mensagem"    => array(NULL,"RESMO", 1)
		)

	);    

?>