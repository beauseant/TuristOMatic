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


            if ($_REQUEST['criterio'] ==''){
                echo '
                    <div class="alert alert-danger">
                            <strong>Necesito al menos un criterio de busqueda...</strong>:
                            <a href="buscar.php">pulse para añadirla</a>
                    </div>                
                ';
                exit();                    

            }

            switch ($_REQUEST['buscadorSelect']) {
                case 'DE':
                    $dbname = 'TuristOMaticDE';
                    break;
                case 'IT':
                    $dbname = 'TuristOMaticIT';
                    break;
                case 'FR':
                    $dbname = 'TuristOMaticFR';
                    break;
                case 'UK':
                    $dbname = 'TuristOMaticUK';
                    break;
                default:
                    echo '
                          <div class="alert alert-warning">
                                <strong>Idioma no válido</strong>
                          </div>                                
                        ';
                    exit();
            }                

            
            $db = new Database ($DB_HOST , $dbname, array("username" => $DB_USER, "password" => $DB_PWD) );

            $busqueda = $db->searchQuery ($_REQUEST['criterio']);

            foreach ($busqueda as $b) {
                print_r ( $b );
            }

            #include ('includes/acordeonDestinos.php');

      ?>
    </div>
    <!-- /.container -->

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>