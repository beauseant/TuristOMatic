<?php
    
    include_once ("includes/genericheader_navegacion.php");
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
                
                
                if (! isset ($_SESSION['buscador'])) {
                    $_SESSION['buscador'] = $_REQUEST['buscadorSelect'];
                }
                
                $strDestinos = '';
                foreach ($_SESSION['listDestinos'] as $key => $value) {

                    $strDestinos = $strDestinos . ','.  $value;

                }
                echo '
                    <div class="alert alert-info">
                            <strong>Destinos seleccionados</strong>:'. $strDestinos  .'
                    </div>                
                ';                

                echo '
                    <div class="alert alert-info">
                            <strong>Buscador seleccionado</strong>:'. $_SESSION['buscador']  .'
                    </div>                
                ';

                include_once ("classes/class.Database.php");
                require ("config.php");
    
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
                $categorias = $db->getCategorias ();
                $_SESSION['dbname'] = $dbname;
        

                $salida = '   
                <form id="categoriasfrm"  method="POST" action="resultados.php">
                    <div class="table-responsive">
                            <table id="categorias_table" class="table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Categoría</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                ';
        
                foreach ($categorias as $key => $value) {
                    $salida = $salida . '<tr>';
                    $salida = $salida . '<td>' . $value['consulta'] .'</td>';            
                    $salida = $salida . '<td>                                
                                            <input type="checkbox" name="'. $value['idcategoria'] .'" value="'. $value['consulta'] . '" >
                                        ';            
                    $salida = $salida . '</td></tr>';
                }
            
                $salida = $salida . '
                            <tbody>
                        </table>
                    </div>
                    <h1></h1>
                    <button type="submit" value="ok" class="btn btn-primary">Siguiente</button>                        
                </form>
                ';
        
                print ($salida);
 
                ?>

 
   <script type="text/javascript">
        // For demo to fit into DataTables site builder...
        $('#categorias_table').
        dataTable({
            "pageLength": 25,
            "searching": false
        });
    </script>
 
