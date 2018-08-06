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
                            <strong>Destinos seleccionados</strong>: '. ltrim ($strDestinos, ',')  .'
                    </div>                
                ';

                $strConsultas = '';
                foreach (array_values ($_SESSION['listCategorias']) as $value) {

                    $strConsultas = $strConsultas . ','.  $value;

                }
                #print_r (array_keys ($_SESSION['listCategorias']));
                echo '
                    <div class="alert alert-info">
                            <strong>Consultas seleccionadas</strong>: '. ltrim ($strConsultas, ',')  .'
                    </div>                
                ';
    

                $strResultados = '';
                foreach (array_values ($_REQUEST) as $value) {

                    $strResultados = $strResultados . ','.  $value;

                }
                echo '
                    <div class="alert alert-info">
                            <strong>Resultados seleccionados</strong> ('. ltrim($strResultados,',')   .')
                            <strong>para el dominio ' . $_SESSION['buscador']  .'
                    </div>                
                ';
                                    
                $db = new Database ($DB_HOST , $_SESSION['dbname'], array("username" => $DB_USER, "password" => $DB_PWD) );

                $busquedas = $db->getBusquedasFilter ( array_keys ($_SESSION['listConsultas']), 
                                                 array_keys ($_SESSION['listDestinos']),
                                                 array_keys ($_REQUEST)
                                    );
                
                $consultas = $db -> getConsultas ();

                $listCategorias = $db -> getListCategorias ();

                $consultasDict = array();
                $consultasById = array ();

                foreach ($consultas as $key => $value) {
                    $salida = '';
                    $ids = array();

                    foreach ($value['categorias'] as $categoriaid ) {
                        $ids[] = $categoriaid;
                    }
                    foreach ($value['categoriasText'] as $categoria ) {
                        $salida = $salida . ',' . $categoria;
                    }
                    $consultasDict[$value['idconsulta']] = [$salida, $value['consulta']];
                    $consultasById[$value['idconsulta']] = $ids;

                    /*if ($value['idconsulta'] == 120){
                        print $salida;
                        print_r ($ids);
                        print_r ($consultasDict[$value['idconsulta']]);
                    }*/
                    
                    
                }

                //print ( implode(',', $listCategorias));
                
                //$salida = $busquedas->toArray();*/


                #php://temp, guarda en memoria hasta dos megas, el resto a disco
                #memory todo en memoria:
                #$_SESSION['fileOutput'] = fopen('php://memory', "wr") ;

                #$salida = $_SESSION['fileOutput'];
                $filename = 'tmp/' . session_id() .'.csv';
                $salida = fopen ($filename,'wr');

                $contador = 0;                            
                foreach ($busquedas as $key => $value) {
                    $value['iddestino'] = $_SESSION['listDestinos'][$value['iddestino']];
                    $value['categoria'] = $consultasDict[$value['idconsulta']][0];

                    $idconsultaOrg = $value['idconsulta'];
                    $value['idconsulta'] = $consultasDict[$value['idconsulta']][1];
                    if(isset(parse_url($value['URL'])['host'])) {
                        $value['domain_url'] = parse_url($value['URL'])['host'];
                    }else{
                        $value['domain_url'] = '-----';
                    }
                    $contadorcats = 0;

                    /*print_r ($listCategorias);
                    print('###################################################################');
                    print_r ($consultasById[ $idconsultaOrg]);
                    print('###################################################################');
                    print ($value['categoria']);
                    print('###################################################################');
                    print ($idconsultaOrg);
                    exit();*/

                    foreach ( $listCategorias as $cat) {
                        
                        if ( in_array ($contadorcats, $consultasById[ $idconsultaOrg])){
                            $value [$cat] = 1;
                        }else {
                            $value [$cat] = 0;
                        }
                        $contadorcats++;
                    }
                    if ($contador==0){
		    	foreach ($value as $keydato => $dato) {
                            fwrite ($salida,('"' . $keydato . '",'));                                
			}
                    	fwrite ($salida, PHP_EOL);
                    }
		   foreach ($value as $keydato => $dato) {
		         fwrite ($salida,('"' . $dato . '",'));                            

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
                #print_r ($salida);

            ?>



