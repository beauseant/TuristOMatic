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
                            <strong>Destinos seleccionados</strong>:'. $strDestinos  .'
                    </div>                
                ';                

                echo '
                    <div class="alert alert-info">
                            <strong>Buscador seleccionado</strong>:'. $_SESSION['buscador']  .'
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
                $categorias = $db->getCategorias ();
                $_SESSION['dbname'] = $dbname;
        

                $salida = '   
                <form id="categoriasfrm"  method="POST" action="resultados.php">
                    <div class="table-responsive">
                            <table id="categorias_table" class="table" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Categoría</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                ';
        
                foreach ($categorias as $key => $value) {                    
                    $salida = $salida . '<tr>';
                    $salida = $salida . '<td>' . $value['idcategoria'] .'</td>';    
                    $salida = $salida . '<td>' . $value['consulta'] .'</td>';    
                    $salida = $salida . '<td>                                
                                            <input class="all_chcktbl" id= "' . $value['idcategoria']. '_chcktbl" type="checkbox" " name="'. $value['idcategoria'] .'" value="'. $value['consulta'] . '" >
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

                echo '
                        <script type="text/javascript">    
                        // For demo to fit into DataTables site builder...
                        $(document).ready(function() {              
                            var table = $(\'#categorias_table\').
                                DataTable({
                                    "pageLength": 15,
                                    "searching": true,
                                    "lengthChange": false,
                                    select: {
                                        style: \'multi\'
                                    },
                                    dom: \'Bfrtip\',
                                    buttons: [
                                        \'selectAll\',
                                        \'selectNone\'
                                    ],
                                    language: {
                                        buttons: {
                                            selectAll: "seleccionar todos",
                                            selectNone: "no seleccionar ninguno"
                                        }
                                    },
                                    "columnDefs": [{"targets":[0],"visible":false,"searchable":false}]            
                                });
            
                            table
                                .on( "select", function ( e, dt, type, indexes ) {
                                    var rowData = table.rows( indexes ).data().toArray();
                                    var chkbox = $("#"+  ((rowData[0][0] + "_chcktbl")));
                                    chkbox.prop("checked", true);
                                    
                                } )
                                .on( "deselect", function ( e, dt, type, indexes ) {
                                    var rowData = table.rows( indexes ).data().toArray();
                                    var chkbox = $("#"+ ((rowData[0][0] + "_chcktbl")));
                                    chkbox.prop("checked", false);
            
                                } );     

                                table.on( "buttons-action", function ( e, buttonApi, dataTable, node, config ) {                                    
                                    if (buttonApi.text() == "seleccionar todos") {                        
                                        
                                        //Cambiamos el numero de elementos mostrados porque sino falla al hacer el checkbox, solo 
                                        //lo hace de los que se muestran en pantalla.
                                        table.page.len(-1).draw()
                                        $(\'.all_chcktbl:not(:checked)\').attr(\'checked\', true);
                                    }else{
                                        table.page.len(10).draw()
                                        $(\'.all_chcktbl:checked\').attr(\'checked\', false);
                                    }
                                } );   
                
                                
                                
                        });
                    </script>

                ';

                ?>

 
