<?php
    
    $salida = '                                   
        <div class="table-responsive">
                <table id="'. $contador .'_table' .'" class="table" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Nombre normalizado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
    ';

    foreach ($destinos as $dest) {
        $salida = $salida . '<tr>';


        $salida = $salida . '<td>' . $dest[0] .'</td>';            
        $salida = $salida . '<td>' . $dest[1] .'</td>';      

        $salida = $salida . '<td>                                
                                <input type="checkbox" name="'. $dest[2] .'" value="'. $dest[1] . '" >
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
            $(\'#'. $contador . '_table' .'\').
                dataTable({
                    "pageLength": 5
            });
            </script>
    ';
?>