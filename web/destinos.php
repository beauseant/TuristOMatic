<?php
    include_once ("includes/genericheader_navegacion.php");
?>

    <!-- Page Content -->
    <div class="container">
      <h1 class="mt-5">Seleccione un destino</h1>
      <?php
            include_once ("classes/class.Database.php");
            require ("config.php");
            session_start(); 

            #tomamos los destinos de la bd
            $dbname = 'TuristOMaticUK';
            #,"ssl" => false
            $db = new Database ($DB_HOST , $dbname, array("username" => $DB_USER, "password" => $DB_PWD) );
            $destinosPorTipo = $db->getDestinos ();
            include ('includes/acordeonDestinos.php');

      ?>
    </div>
    <!-- /.container -->

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>