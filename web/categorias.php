<?php
    
    include_once ("includes/genericheader_navegacion.php");
    include_once ("classes/class.Database.php");
    require ("config.php");

    session_start(); 

?>
        <!-- Page Content -->
        <div class="container">
            <h1></h1>
            

            <?php

                
            
                if (sizeof ($_REQUEST)== 0 && ! isset ($_SESSION['buscador'])) {
                    echo '
                    <div class="alert alert-danger">
                            <strong>Necesito al menos un buscador seleccionado...</strong>:
                            <a href="index.php">Vuelva al inicio para añadir</a>
                    </div>                
                ';
                exit();
                    
                }
                
                #print ($_REQUEST['buscadorSelect']);
                #print ($_SESSION['buscador']);
                if (! isset ($_SESSION['buscador'])) {
                    
                    $_SESSION['buscador'] = $_REQUEST['buscadorSelect'];
                }
                
                $strDestinos = '';
                foreach ($_SESSION['listDestinos'] as $key => $value) {

                    $strDestinos = $strDestinos . ','.  $value;

                }
                echo '
                    <div class="alert alert-info">
                            <strong>Destinos seleccionados</strong>: '. ltrim($strDestinos,',')  .'
                    </div>                
                ';                

                echo '
                    <div class="alert alert-info">
                            <strong>Dominio de búsqueda</strong>: '. $_SESSION['buscador']  .'
                    </div>                
                ';

    
                #tomamos los destinos de la bd
                switch ($_SESSION['buscador']) {
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
                #,"ssl" => false
                $db = new Database ($DB_HOST , $dbname, array("username" => $DB_USER, "password" => $DB_PWD) );
                $categoriasPorTipo = $db->getCategorias ();

                $_SESSION['dbname'] = $dbname;

                include ('includes/acordeonCategorias.php');

            ?>
        </div>
    <!-- /.container -->

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    </body>

</html>