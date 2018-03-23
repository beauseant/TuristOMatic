        <?php



            include_once ("includes/genericheader_navegacion.php");
        ?>

        <!-- Page Content -->
        <div class="container">
            <h1></h1>
            <?php

                $strDestinos = '';

                foreach ($_REQUEST as $key => $value) {

                    $strDestinos = $strDestinos . ','.  $value;

                }
                echo '
                    <div class="alert alert-info">
                            <strong>Destinos seleccionados</strong>:'. $strDestinos  .'
                    </div>                
                ';

                $_SESSION['listDestinos'] = $_REQUEST;

            ?>
                <h1 class="mt-5">Seleccione un buscador:</h1>

                <form>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Example select</label>
                            <select class="form-control" id="exampleFormControlSelect1">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                    </div>
                </form>
        </div>
            <!-- /.container -->

            <!-- Bootstrap core JavaScript -->
            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>