<?php

session_start();
require_once('../config/config.php');





if (isset($_POST['id']) && is_numeric($_POST['id'])) {
       Query("DELETE from galerias_fotos where Galerias_fotos = '".$_POST['id']."'");
}