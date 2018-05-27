        <?php
            
            include ("includes/genericheader_navegacion.php");
            include_once ("classes/class.Database.php");
            
        ?>

        <!-- Page Content -->
        <div class="container">
            <h1></h1>
            
                
                <h1 class="mt-5">Introduzca un criterio de búsqueda y un dominio:</h1>
                <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                                <form class="panel panel-default" id="Frmbuscador"  method="POST" action="resultadosBusqueda.php">
                                    <div class="xxform-inline">
                                        <input name="criterio" class="form-control" id="criteriobuscar" rows="1" cols="10"></input>
                                        <input style="visibility:hidden;" type="text" class="form-control" id="critBusqueda" >
                                        <?php include ('includes/listabuscadores.php');?>
                                        <button type="submit" class="btn btn-primary float-right">Siguiente</button>
                                    </div>
                                </form>
                        </div>
                        <div class="col-md-3"></div>
                </div>
        </div>
            <!-- /.container -->

            <!-- Bootstrap core JavaScript -->
            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>