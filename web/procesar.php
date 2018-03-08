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
        <div class="row">
          <div class="col-lg-8 mx-auto text-primary">
            <?PHP

                  include_once ("classes/class.Database.php");
                  require ("config.php");

                  

                  switch ($_REQUEST['idioma']) {
                      case 'DE':
                          $dbname = 'TuristOMaticDE';
                          break;
                      case 'IT':
                          $dbname = 'TuristOMaticIT';
                          break;
                      case 'FR':
                          $dbname = 'TuristOMaticFR';
                          break;
                      case 'UK':
                          $dbname = 'TuristOMaticUK';
                          break;
                      default:
                          echo '
                                <div class="alert alert-warning">
                                      <strong>Idioma no válido</strong>
                                </div>                                
                              ';
                          exit();

                  }

                  $_SESSION['dbname'] = $dbname;

                  switch ($_REQUEST['busqueda']) {
                            case 'destino':
                                include ('includes/destinos.php');
                                break;
                            case 'consulta':
                                include ('includes/consultas.php');
                                break;
                            default:
                                  echo '
                                        <div class="alert alert-warning">
                                              <strong>Búsqueda no válida</strong>
                                        </div>                                
                                      ';
                                  exit();
                  }

                                #<button type="submit"><i class="fa fa-paper-plane"></i></button>				
              ?>
          </div>
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



