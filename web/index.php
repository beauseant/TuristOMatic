<?php
  session_start(); 
  include ('includes/genericheader.php');

  if (isset ($_REQUEST['action']) || (isset ($_SESSION['action']))) {

    $_SESSION['action'] = 1;
    include ('includes/cargar.php');

  }else {
    include ('includes/inicio.php');
  }
?>




