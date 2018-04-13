<?php
    
    $salida = '                                   
        <div class="table-responsive">
                <table id="'. $contador .'_table' .'" class="table" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Consulta</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
    ';

    #print_r ($_SESSION['listDestinos']);
    foreach ($categorias as $cat) {
        $salida = $salida . '<tr>';

        $estado = '';
        if (isset ($_SESSION['listCategorias'])){
            if (array_key_exists ($dest[2],$_SESSION['listCategorias'])){
                $estado = 'checked';
            }
        }
        $salida = $salida . '<td>' . $cat[1] .'</td>';            
        $salida = $salida . '<td>' . $cat[0] .'</td>';            
        
        

        $salida = $salida . '<td>                                
                                <input type="checkbox"   class = "'. $contador. '_chcktbl" id = "'. $cat[1]. '_chcktbl" name="'. $cat[1] .'" value="'. $cat[0] . '" ' . $estado .' " >
                            ';

        $salida = $salida . '</tr></td>';
    }
    
    $salida = $salida . '
                <tbody>
            </table>
        </div>

    ';

    print ($salida);

    echo '

            <script type="text/javascript">    
        


            // For demo to fit into DataTables site builder...
            $(document).ready(function() {                  
                var table = $(\'#'. $contador . '_table' .'\').
                    DataTable({
                        "pageLength": 10,
                        "searching": true,
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
                    //events.prepend( \'<div><b>\'+type+\' selection</b> - \'+JSON.stringify( rowData )+\'</div>\' );
                    var chkbox = $("#"+  ((rowData[0][0] + "_chcktbl")));
                    chkbox.prop("checked", true);
                    //console.log(rowData[0][0]);

                    
                } )
                .on( "deselect", function ( e, dt, type, indexes ) {
                    var rowData = table.rows( indexes ).data().toArray();
                    //events.prepend( \'<div><b>\'+type+\' <i>de</i>selection</b> - \'+JSON.stringify( rowData )+\'</div>\' );
                    var chkbox = $("#"+ ((rowData[0][0] + "_chcktbl")));
                    chkbox.prop("checked", false);
                    //console.log(rowData);
                } );             
                table.on( "buttons-action", function ( e, buttonApi, dataTable, node, config ) {
                    
                    if (buttonApi.text() == "seleccionar todos") {                        
                        
                        //Cambiamos el numero de elementos mostrados porque sino falla al hacer el checkbox, solo 
                        //lo hace de los que se muestran en pantalla.
                        table.page.len(-1).draw()
                        $(\'.'. $contador . '_chcktbl:not(:checked)\').attr(\'checked\', true);
                    }else{
                        table.page.len(10).draw()
                        $(\'.'. $contador .'_chcktbl:checked\').attr(\'checked\', false);
                    }
                } );   

            });
            </script>
    ';
?>