<?php
    
    
    include_once ("includes/genericheader_navegacion.php");
    include ("classes/class.Database.php");
    require ("config.php");
    session_start(); 


?>
        <!-- Page Content -->
        <div class="container">
            <h1></h1>
            

            <?php
            
                if (sizeof ($_REQUEST)== 0){
                        echo '
                        <div class="alert alert-danger">
                                <strong>Necesito al menos un tipo de resultado seleccionado...</strong>:
                                <a href="javascript:history.go(-1)">pulse para añadirla</a>
                        </div>                
                    ';
                    exit();                    
                }


                $strDestinos = '';

                foreach ($_SESSION['listDestinos'] as $key => $value) {

                    $strDestinos = $strDestinos . ','.  $value;

                }
                print_r (array_keys ($_SESSION['listDestinos']));
                echo '
                    <div class="alert alert-info">
                            <strong>Destinos seleccionados</strong>:'. $strDestinos  .'
                    </div>                
                ';

                $strConsultas = '';
                foreach (array_values ($_SESSION['listCategorias']) as $value) {

                    $strConsultas = $strConsultas . ','.  $value;

                }
                print_r (array_keys ($_SESSION['listCategorias']));
                echo '
                    <div class="alert alert-info">
                            <strong>Consultas seleccionadas</strong>:'. $strConsultas  .'
                    </div>                
                ';


                $strResultados = '';
                foreach (array_values ($_REQUEST) as $value) {

                    $strResultados = $strResultados . ','.  $value;

                }
                echo '
                    <div class="alert alert-info">
                            <strong>Tipo de resultados seleccionados</strong>:'. $strResultados  .'
                    </div>                
                ';
                                
                $db = new Database ($DB_HOST , $_SESSION['dbname'], array("username" => $DB_USER, "password" => $DB_PWD) );

                $busquedas = $db->getBusquedasFilter ( array_keys ($_SESSION['listCategorias']), 
                                                 array_keys ($_SESSION['listDestinos']),
                                                 array_keys ($_REQUEST)
                                    );

                $contador = 0;
                $salida = '';
                foreach ($busquedas as $key => $value) {
                    foreach ($value as $keydato => $dato) {
                        $salida = $salida . ($keydato . ':' . $dato);
                        $salida = $salida . '<br>';                        
                    }
                    $salida = $salida .  '<br>';                        
                    $salida = $salida . '-----';
                    $contador ++;
                }

                echo '<h1>Encontradas: ' . $contador . 'búsquedas con esos datos:</h1>';
                echo $salida;

            ?>