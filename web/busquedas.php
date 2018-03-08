<?php
  session_start(); 
  require ("includes/genericheader.php");
?>

  <body id="page-top" >

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="index.php">inicio</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- 
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#about">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#services">Services</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#contact">Contact</a>
            </li>
          </ul>
        </div>
        --> 
      </div>
    </nav>

    <header class="bg-primary text-white">
      <div class="container text-center">
        <h1>Búsqueda por destinos</h1>
        <p class="lead">Seleccione un destino</p>
      </div>
    </header>

    <section id="about" class = "bg-light">
      <div class="container">
        <div class="row text-primary">
            <?PHP

                  include_once ("classes/class.Database.php");
                  require ("config.php");

                  if (isset ($_REQUEST['iddestino']) or (isset ($_REQUEST['idconsulta']) )) {


                      $data =     [
                            "Destination",
                            "Domain",
                            "Estimated Position",
                            "Estimated SEM Position",
                            "Estimated SEO Position",
                            "ID",
                            "Paid",
                            "Position",
                            "Query",
                            "SEM Position",
                            "SEO Position",
                            "Sitelinks",
                            "Subposition",
                            "Type",
                            "URL"
                          ];



                      $db = new Database ($DB_HOST , $_SESSION['dbname'], array("username" => $DB_USER, "password" => $DB_PWD) );

                      $page  = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                      $limit = 8;
                      $skip  = ($page - 1) * $limit;
                      $next  = ($page + 1);
                      $prev  = ($page - 1);
                      #$sort  = array('createdAt' => -1);

                      if (isset ($_REQUEST['iddestino'])){
                        $result = $db->getBusquedasDestino ( $_REQUEST['iddestino'], $skip, $limit );
                      }

                      if (isset ($_REQUEST['idconsulta'])){
                       $result = $db->getBusquedasConsulta ( $_REQUEST['idconsulta'], $skip, $limit ); 
                      }

                      $salida = '                                   
                                <div class="table-responsive">
                                            <table id="busqueda" class="table" cellspacing="0" width="100%">
                                                <thead class="thead-dark">
                                                    <tr>
                            ';
                      foreach ($data as $col) {
                          $salida = $salida . '<th>' . $col .'</th>';
                      }

                      $salida = $salida . '</tr>
                          </thead>
                          <tbody>
                        ';


                      foreach ($result as $entry) {
                            $salida = $salida . '<tr>';

                            foreach ($data as $col){
                                $salida = $salida . '
                                            <td>' . $entry[ $col ] . '</td>
                                ';
                            }
                            $salida = $salida .                    
                                    '<td> 
                                        <form method="POST" action="datosbusqueda.php">  
                                         <input type="hidden" name="idbusqueda" value="'. $entry['ID']  .' "> 
                                                              <a href="#" onclick="$(this).closest(\'form\').submit()"><i class="fa fa-paper-plane"></i></a>
                                        </form>
                                        </td>
                                  </tr>
                                ';
                      }

                      $salida = $salida . '
                                  </tbody>                            
                            </table>
                          </div>
                      ';


                          echo $salida;

                          #es incorrecto porque estamos filtrando, deberia ser el total del filtrado.
                          $total= $db->getTotalBusquedas ();


                          if (isset ($_REQUEST['iddestino'])){
                                echo '<div class=" col-md-8 p-3 mb-2 bg-dark text-white"> Encontrados '. $total . ' registros.';
                                        if($page > 1){
                                            echo '<a href="?page=' . $prev . '&iddestino=' . $_REQUEST['iddestino'] . '">Anteriores</a>';
                                            if($page * $limit < $total) {
                                                echo ' <a href="?page=' . $next . '&iddestino=' . $_REQUEST['iddestino'] . '">Siguientes</a>';
                                            }
                                        } else {
                                            if($page * $limit < $total) {
                                                echo ' <a href="?page=' . $next . '&iddestino=' . $_REQUEST['iddestino'] . '">Siguientes</a>';
                                            }
                                        }
                                echo '</div>';
                          }else {
                                echo '<div class=" col-md-8 p-3 mb-2 bg-dark text-white"> Encontrados '. $total . ' registros.';
                                        if($page > 1){
                                            echo '<a href="?page=' . $prev . '&idconsulta=' . $_REQUEST['idconsulta'] . '">Anteriores</a>';
                                            if($page * $limit < $total) {
                                                echo ' <a href="?page=' . $next . '&idconsulta=' . $_REQUEST['idconsulta'] . '">Siguientes</a>';
                                            }
                                        } else {
                                            if($page * $limit < $total) {
                                                echo ' <a href="?page=' . $next . '&idconsulta=' . $_REQUEST['idconsulta'] . '">Siguientes</a>';
                                            }
                                        }
                                echo '</div>';



                          }
                } else {

                    echo '
                          <div class="alert alert-warning">
                          <strong>Destino no válido.</strong>
                          </div>                                
                    ';


                }

              ?>
          </div>
      </div>
    </section>
    
<?php
  include ('includes/genericfooter.php')

?>

    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
      // For demo to fit into DataTables site builder...
      $('#example').
        dataTable({
        	"pageLength": 10
      });
    </script>



  </body>

</html>



