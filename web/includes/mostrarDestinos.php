<?php
    
    $salida = '                                   
        <div class="table-responsive">
                <table id="'. $contador .'_table' .'" class="table" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Nombre normalizado</th>
                            <th>Seleccionar todos <input type="checkbox" id ="'. $contador . '_chckHead"/></th>
                        </tr>
                    </thead>
                    <tbody>
    ';

    #print_r ($_SESSION['listDestinos']);
    foreach ($destinos as $dest) {
        $salida = $salida . '<tr>';

        $estado = '';
        if (isset ($_SESSION['listDestinos'])){
            if (array_key_exists ($dest[2],$_SESSION['listDestinos'])){
                $estado = 'checked';
            }
        }
        $salida = $salida . '<td>' . $dest[0] .'</td>';            
        $salida = $salida . '<td>' . $dest[1] .'</td>';
        
        

        $salida = $salida . '<td>                                
                                <input type="checkbox"  class = "'. $contador. '_chcktbl" name="'. $dest[2] .'" value="'. $dest[1] . '" ' . $estado .' " >
                            ';

        $salida = $salida . '</tr></td>';
    }
    
    $salida = $salida . '
                <tbody>
            </table>
        </div>

        <script type="text/javascript">>
        </script>

    ';

    print ($salida);

    echo '

            <script type="text/javascript">    
            $(\'#'. $contador . '_chckHead\').click(function () {

                if (this.checked == false) {
        
                    $(\'.'. $contador .'_chcktbl:checked\').attr(\'checked\', false);
                }
                else {
                    $(\'.'. $contador . '_chcktbl:not(:checked)\').attr(\'checked\', true);
        
                }
            });
        


            // For demo to fit into DataTables site builder...
            $(\'#'. $contador . '_table' .'\').
                dataTable({
                    "pageLength": 5,
                    "searching": false
            });
            </script>
    ';
?>