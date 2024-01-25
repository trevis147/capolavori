<?php require_once("config.php");
	

	

	function removeAcentos($string, $separator = '-') {

        $accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';

        $special_cases = array('&' => 'and');

        $string = mb_strtolower(trim($string), 'UTF-8');

        $string = str_replace(array_keys($special_cases), array_values($special_cases), $string);

        $string = preg_replace($accents_regex, '$1', htmlentities($string, ENT_QUOTES, 'UTF-8'));

        $string = preg_replace("/[^a-z0-9]/u", "$separator", $string);

        $string = preg_replace("/[$separator]+/u", "$separator", $string);

        return $string;

    }


	
	$q = Query("SELECT Produto,Titulo FROM produto",0);

	while($r = mysqli_fetch_assoc($q)){
		Query("UPDATE produto set Url = '".removeAcentos($r["Titulo"])."' WHERE Produto = ".$r['Produto']."");    	
	}

	