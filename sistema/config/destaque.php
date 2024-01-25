<?php

require_once('config.php');

if (isset($_POST['tabela']) && $_POST['tabela'] != '') {
    
    $SQL_ativa = Query("SELECT Destaque FROM ".$_POST['tabela']." WHERE ".ucfirst($_POST['tabela'])." = '" . $_POST['var'] . "'",0);
    $Ativa = mysqli_fetch_assoc($SQL_ativa);

    if ($Ativa['Destaque'] == '0') {
        Query("UPDATE ".$_POST['tabela']." SET Destaque = '1' WHERE  ".ucfirst($_POST['tabela'])." = '".$_POST['var']."' ",0);
        echo '1';
    } else {
        Query("UPDATE ".$_POST['tabela']." SET Destaque = '0' WHERE  ".ucfirst($_POST['tabela'])." = '".$_POST['var']."' ",0);
        echo '2';
    }


   
}

