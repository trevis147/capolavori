<?php

require_once('config.php');

  
    
   Query("UPDATE banner_modo set Modo = '" . $_POST['var'] . "' where Banner_modo=1",0);



