<?php

	$Arr = array();

	$ArrMenu = $Configuracoes["Menu"];
	foreach($Gerenciamentos as $i => $v) {
		if(array_key_exists($i, $Configuracoes["Tabela"])) {
			if($Configuracoes["Tabela"][$i][0] == 1) {
				$ArrMenu[$i] = "registros/".$i;
			} 
		} else {
			$ArrMenu[$i] = "registros/".$i;
		}
	}

	ksort($ArrMenu);

?>
<div class="unit-20" id="Sidebar">
    <nav class="nav-v">
        <ul>
        	<?php
				foreach($ArrMenu as $i => $v) {
					?>
                    <li><a href="<?php echo $Config["Url"]; ?><?php echo $v; ?>"><?php echo ucfirst(Nomes($i)); ?></a></li>
                    <?php	
				}
			?>
        </ul>
    </nav>
</div>


