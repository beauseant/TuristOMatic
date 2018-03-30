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
                                <a href="resultados.php">pulse para añadirla</a>
                        </div>                
                    ';
                    exit();                    
                }


                $strDestinos = '';

                foreach ($_SESSION['listDestinos'] as $key => $value) {

                    $strDestinos = $strDestinos . ','.  $value;

                }
                #print_r (array_keys ($_SESSION['listDestinos']));
                echo '
                    <div class="alert alert-info">
                            <strong>Destinos seleccionados</strong>:'. $strDestinos  .'
                    </div>                
                ';

                $strConsultas = '';
                foreach (array_values ($_SESSION['listCategorias']) as $value) {

                    $strConsultas = $strConsultas . ','.  $value;

                }
                #print_r (array_keys ($_SESSION['listCategorias']));
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

                $busquedas = $db->getBusquedasFilter ( array_keys ($_SESSION['listConsultas']), 
                                                 array_keys ($_SESSION['listDestinos']),
                                                 array_keys ($_REQUEST)
                                    );
                
                $consultas = $db -> getConsultas ();
                $consultasDict = array();
                foreach ($consultas as $key => $value) {
                    $salida = '';
                    foreach ($value['categoriasText'] as $categoria ) {
                        $salida = $salida . ',' . $categoria;
                    }
                    $consultasDict[$value['idconsulta']] = [$salida, $value['consulta']];
                    
                }

                //$salida = $busquedas->toArray();*/


                #php://temp, guarda en memoria hasta dos megas, el resto a disco
                #memory todo en memoria:
                #$_SESSION['fileOutput'] = fopen('php://memory', "wr") ;

                #$salida = $_SESSION['fileOutput'];
                $salida = fopen ('tmp/salida.csv','wr');

                $contador = 0;                            
                foreach ($busquedas as $key => $value) {
                    $value['iddestino'] = $_SESSION['listDestinos'][$value['iddestino']];
                    $value['categoria'] = $consultasDict[$value['idconsulta']][0];
                    $value['idconsulta'] = $consultasDict[$value['idconsulta']][1];

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

                $filename = 'tmp/salida.csv';

                $size = filesize($filename);
                $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
                $power = $size > 0 ? floor(log($size, 1024)) : 0;
                $size = number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];

                echo '<a href="descarga.php">Descargar (' .  $size . ')</a>';
                #print_r ($salida);

            ?>