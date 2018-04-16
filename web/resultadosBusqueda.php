<?php
    include_once ("includes/genericheader_navegacion.php");
?>

    <!-- Page Content -->
    <div class="container">
      <h1 class="mt-5"><br></h1>
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

            $filename = 'tmp/' . session_id() .'_Busqueda.csv';
            $salida = fopen ($filename,'wr');

            $contador = 0;                            
            foreach ($busqueda as $key => $value) {
                foreach ($value as $keydato => $dato) {
                    if ($contador == 0){
                        fwrite ($salida,('"' . $keydato . '",'));                                
                    }else {
                        fwrite ($salida,('"' . $dato . '",'));                            
            }
                }
                fwrite ($salida, PHP_EOL);
                $contador ++;
            }
            fclose ($salida);
            

            echo '<h1>Encontradas: ' . $contador . ' búsquedas con esos datos:</h1>';                

            $size = filesize($filename);
            $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
            $power = $size > 0 ? floor(log($size, 1024)) : 0;
            $size = number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];

            echo '
                <form class="panel panel-default" id="descarga"  method="POST" action="descarga.php"> 
                    <input type="submit" class="btn btn-primary" value="Descargar ('. $size .')">
                    <input type="hidden" name="filename" value="'.$filename .'">
                </form>
            ';


      ?>
    </div>
    <!-- /.container -->

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>