<?php

require_once('config.php');

if (isset($_POST['tabela']) && $_POST['tabela'] != '') {
    
    $SQL_ativa = Query("SELECT ".$_POST['Campo']." FROM ".$_POST['tabela']." WHERE ".ucfirst($_POST['tabela'])." = '" . $_POST['var'] . "'",0);
    $Ativa = mysql_fetch_assoc($SQL_ativa);

    if ($Ativa[$_POST['Campo']] == '0') {
        Query("UPDATE ".$_POST['tabela']." SET ".$_POST['Campo']." = '1' WHERE  ".ucfirst($_POST['tabela'])." = '".$_POST['var']."' ",0);
        echo '1';
    } else {
        Query("UPDATE ".$_POST['tabela']." SET ".$_POST['Campo']." = '0' WHERE  ".ucfirst($_POST['tabela'])." = '".$_POST['var']."' ",0);
        echo '2';
    }



}

