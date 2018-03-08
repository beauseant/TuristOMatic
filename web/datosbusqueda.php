<?php
  session_start(); 
  require ("includes/genericheader.php");
?>

  <body id="page-top" >

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="index.php">inicio</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- 
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#about">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#services">Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#contact">Contact</a>
            </li>
          </ul>
        </div>
        --> 
      </div>
    </nav>

    <header class="bg-primary text-white">
      <div class="container text-center">
        <h1>Búsqueda por destinos</h1>
        <p class="lead">Datos de la búsqueda</p>
      </div>
    </header>

    <section id="about" class = "bg-light">
      <div class="container">
        <div class="row">
          <div class="col-lg-8 mx-auto text-primary">
            <?PHP

                  include_once ("classes/class.Database.php");
                  require ("config.php");

                   if (! isset ($_REQUEST['idbusqueda'])) {

                      echo '
                          <div class="alert alert-warning">
                          <strong>búsqueda no válida</strong>
                          </div>                                
                    ';
                    exit();
                   }

                  $db = new Database ($DB_HOST , $_SESSION['dbname'], array("username" => $DB_USER, "password" => $DB_PWD) );

                  $busqueda= $db->getBusqueda ( $_REQUEST['idbusqueda'] );

                  foreach ($busqueda as $b) {

                      print_r ($b);
                      print '------------';


                  }





           ?>

