<?php
  session_start(); 
  include ('includes/genericheader.php')
?>


  <body id="page-top">

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="#page-top">2018</a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          Menu
          <i class="fa fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#about">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#download">Download</a>
            </li>
            <li class="nav-item">
              <a class="nav-link js-scroll-trigger" href="#contact">Contact</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Intro Header -->
    <header class="masthead">
      <div class="intro-body">
        <div class="container">
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <h1 class="brand-heading">TuristOMatic</h1>


              <form class="form-inline" method="POST" action="procesar.php">                    
                <label class="mr-sm-2" for="inlineFormCustomSelect">Idioma:</label>
                    <div class="form-group">
                      <select class="form-control mr-sm-4"  name="idioma" id="exampleSelect1">
                             <option value="DE">DE</option>
                              <option value="UK">UK</option>
                              <option value="IT">IT</option>                      
                      </select>
                      <label class="mr-sm-2" for="inlineFormCustomSelect">Consulta:</label>
                      <select class="form-control mr-sm-2" name="busqueda" id="exampleSelect1">
                             <option value="destino">Búsquedas por destino</option>
                             <option value="consulta">Búsquedas por consulta</option>
                      </select>
                      <button type="submit" class="btn btn-primary">ir</button>
                    </div>
              </form>              
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Footer -->
    <footer>
      <div class="container text-center">
        <p>Copyright &copy; TouristOMatic 2018</p>        
      </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for this template -->
    <script src="js/grayscale.min.js"></script>

  </body>

</html>
