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
            
                if ((sizeof ($_REQUEST)== 0) && !(isset ($_SESSION['listCategorias']))) {
                        echo '
                        <div class="alert alert-danger">
                                <strong>Necesito al menos una categoría seleccionada...</strong>:
                                <a href="categorias.php">pulse para añadirla</a>
                        </div>                
                    ';
                    exit();                    
                }


                $_SESSION['listCategorias'] = $_REQUEST;

                #print_r ($_SESSION['listCategorias']);

                $db = new Database ($DB_HOST , $_SESSION['dbname'], array("username" => $DB_USER, "password" => $DB_PWD) );

                $consultas = $db->getConsultasPorCategoria ( array_keys ($_SESSION['listCategorias']) );

                $listaConsultas = array ();

                foreach ($consultas as $key => $value) {
                    $listaConsultas[$value['idconsulta']] = [$value['categorias'], $value['categoriasText']];
                }
                
                $_SESSION['listConsultas'] = $listaConsultas;
                
                if (sizeof($_SESSION['listConsultas']) ==0) {
                    echo '
                        <div class="alert alert-danger">
                                <strong>La categorías seleccionadas no tienen consultas asociadas...</strong>:
                                <a href="categorias.php">pulse para cambiar la selección</a>
                        </div>                
                    ';
                    exit();
                }

                $strDestinos = '';
                foreach ($_SESSION['listDestinos'] as $key => $value) {

                    $strDestinos = $strDestinos . ','.  $value;

                }
                echo '
                    <div class="alert alert-info">
                            <strong>Destinos seleccionados</strong>: '. ltrim($strDestinos,',')  .'
                    </div>                
                ';

                $strCats = '';
                foreach ($_SESSION['listCategorias'] as $key => $value) {

                    $strCats = $strCats . ','.  $value;

                }
                echo '
                    <div class="alert alert-info">
                            <strong>Categorías seleccionadas</strong>: '. ltrim($strCats,',')  .'
                    </div>                
                ';

                
                
                
                $salida = '
                    <div class="alert alert-info">
                            <strong>Se han encontrado ' . sizeof ($listaConsultas) 
                            .' consultas con las '.sizeof($_SESSION['listCategorias']) .' categorías y los ' . sizeof($_SESSION['listDestinos']) . ' destinos seleccionados (para el buscador '. $_SESSION['buscador'].').</strong>                                                
                    </div>                            
                ';
                            
                echo $salida;

                echo '
                    <h1></h1>
                    <h1 class="mt-5">Seleccione los resultados que quiere obtener:</h1>
                ';

                /* 
                    NO QUEREMOS TODOS LOS TIPOS DE BUSQUEDAS EN LA BD, SOLO UNOS POCOS ELEGIDOS:

                #los distintos tipos de busquedas que hemos guardado, organic, images, sem...
                $tiposBusquedas = $db->getBusquedaTypeDistinct ();

                $salida = '
                        <form class="panel panel-default" id="FrmResultados"  method="POST" action="getresultados.php">
                            <table id="filtrores" class="table table-sm table-hover table-striped"><thead><tr><th></th><th></th></tr></thead><tbody>
                    ';

                    foreach ($tiposBusquedas as $key => $value) {
                    $salida = $salida . '
                                <tr>
                                    <td><label class="form-check-label" for="defaultCheck1">'. $value .'</label></td>
                                    <td><input checked class="form-check-input" type="checkbox" value="'. $value . '" name="'. $value. '"></td>                                    
                                </tr>
                    ';
                }
                */
            ?>


<form class="panel panel-default" id="FrmResultados"  method="POST" action="getresultados.php">
                            <table id="filtrores" class="table table-sm table-hover table-striped"><thead><tr><th></th><th></th></tr></thead><tbody>
                    
                                <tr>
                                    <td><label class="form-check-label" for="defaultCheck1">knowledge</label></td>
                                    <td><input checked class="form-check-input" type="checkbox" value="knowledge" name="knowledge"></td>                                    
                                </tr>
                    
                                <tr>
                                    <td><label class="form-check-label" for="defaultCheck1">organic</label></td>
                                    <td><input checked class="form-check-input" type="checkbox" value="organic" name="organic"></td>                                    
                                </tr>
                                        
                                <tr>
                                    <td><label class="form-check-label" for="defaultCheck1">adwords</label></td>
                                    <td><input checked class="form-check-input" type="checkbox" value="adwords" name="adwords"></td>                                    
                                </tr>
                                        


            <?php


                $salida = $salida . '
                            </tbody></table>
                                <button type="submit" class="btn btn-primary float-right">Siguiente</button>
                            
                        </form>
                        ';
                echo $salida ;

                

            ?>

