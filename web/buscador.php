        <?php
            
            include ("includes/genericheader_navegacion.php");
            include_once ("classes/class.Database.php");
            
        ?>

        <!-- Page Content -->
        <div class="container">
            <h1></h1>
            
            <?php
                
                #comprobamos si en la sesión ya estaba, de ser asi es que venimos desde la pagina anterior:
                if ( (sizeof ($_REQUEST)== 0) ) {
                    echo '
                    <div class="alert alert-danger">
                            <strong>Necesito al menos un destino seleccionado...</strong>:
                            <a href="destinos.php">Vuelva al inicio para añadir</a>
                    </div>                
                ';
                exit();
                    
                }
                session_start(); 
                $_SESSION['listDestinos'] = $_REQUEST;

                #print_r ($_SESSION['listDestinos']);
                

                $strDestinos = '';

                foreach ($_SESSION['listDestinos'] as $key => $value) {

                    $strDestinos = $strDestinos . ','.  $value;

                }
                echo '
                    <div class="alert alert-info">
                            <strong>Destinos seleccionados</strong>:'. $strDestinos  .'
                            <a href="destinos.php">añadir más</a>
                    </div>                
                ';

                    
                

            ?>
                <h1 class="mt-5">Seleccione un buscador:</h1>

                <form class="panel panel-default" id="Frmbuscador"  method="POST" action="categorias.php">
                    <div class="form-inline">
                            <select name="buscadorSelect" class="form-control col-sm-6" id="exampleFormControlSelect1">
                                <option>DE</option>
                                <option>UK</option>
                                <option>FR</option>
                                <option>IT</option>
                            </select>
                            <button type="submit" class="btn btn-primary ">Siguiente</button>
                    </div>
                </form>
        </div>
            <!-- /.container -->

            <!-- Bootstrap core JavaScript -->
            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>