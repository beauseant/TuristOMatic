
<form class="panel panel-default" id='categoriasfrm'  method="POST" action="resultados.php"> 
    <div class="panel-group" id="accordion">
        <?php
            
            $contador = 0;

            foreach ($categoriasPorTipo as $key => $value){

                $collapse = $contador . '_collapse';
                #todos los destinos de ese tipo
                $categorias = $categoriasPorTipo[$key];

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
                                include ('mostrarCategoria.php');                   
                                
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
