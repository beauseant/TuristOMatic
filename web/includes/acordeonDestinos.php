
<form class="panel panel-default" id='empezar'  method="POST" action="buscador.php"> 
    <div class="panel-group" id="accordion">
        <?php
            
            $contador = 0;

            foreach ($destinosPorTipo as $key => $value){

                $collapse = $key . '_collapse';
                #todos los destinos de ese tipo
                $destinos = $destinosPorTipo[$key];

                echo '
                    <div class="card">
                        <div class="card-header">         
                            <h4 class="panel-title">
                                <a class="btn btn-link" data-toggle="collapse" data-parent="#accordion" href="#'. $collapse .'">'.
                                $key  
                                .'</a>
                            </h4>
                        </div>
                        <div id="'. $collapse.'" class="panel-collapse collapse in">
                            <div class="card-body">';


                                include ('mostrarDestinos.php');                   
                    echo '                            
                            </div>
                        </div>
                    </div>            
                ';
                $contador ++;
            }
        ?>
    </div>
    <h1></h1>
    <button type="submit" value='ok' class="btn btn-primary">Siguiente</button>    
</form>
