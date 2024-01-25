	<div id="Header">
        <div class="units-row MaxWid">
            <div class="unit-20 logo">
            	<img src="<?php echo $Config["Url"]; ?>img/LogoMake.png" alt="Make Web" />
            </div>
            <div class="unit-70">
            	
                <nav class="nav-g floright">
                    <ul>
                        <li class="UserTopLi"><img src="<?php echo $Config["Url"]; ?>img/User.png" /> <span><?php echo $_SESSION[$Config["PrefixoSessao"]."Nome"]; ?></span></li>
                        <li><a href="<?php echo $Config["Url"]; ?>index"><img src="<?php echo $Config["Url"]; ?>img/Home.png" /></a></li>
                        <li><a href="<?php echo $Config["Url"]; ?>contato"><img src="<?php echo $Config["Url"]; ?>img/Contact.png" /></a></li>
                        <li><a href="<?php echo $Config["Url"]; ?>usuario"><img src="<?php echo $Config["Url"]; ?>img/Config.png" /></a></li>
                        <li><a href="<?php echo $Config["Url"]; ?>ManualSistemaMake.pdf" target="_blank"><img src="<?php echo $Config["Url"]; ?>img/Ajuda.png" /></a></li>
                        <li><a href="<?php echo $Config["Url"]; ?>sair"><img src="<?php echo $Config["Url"]; ?>img/LogOut.png" /></a></li>
                        <?php
							if(isset($DEBUG) && $DEBUG ==1) {
								?>
                                <li><a href="<?php echo $Config["Url"]; ?>configuracao"><img src="<?php echo $Config["Url"]; ?>img/Debug.png" /></a></li>
                                <?php	
							}
						?>
                    </ul>
                </nav>
                
            </div>
        </div>
    </div>