<?php
require_once('../config/config.php');

$Or = 1;
$pag = $_POST['pag'];

if (isset($_POST['var']) && $_POST['var'] != '') {
    if (isset($pag) && $pag != '') {
        $li = explode(",", $_POST['var']);
        foreach ($li as $n => $value) {
            if (isset($value) && is_numeric($value)) {
               Query('UPDATE '.$pag.' set Ordem ='.$Or.' WHERE '.ucfirst($pag).' = '.$value.'');
               $Or++;
            }
        }
    }
}