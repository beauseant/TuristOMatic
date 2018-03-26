<?php

  include ('includes/genericheader.php');
  session_start();
  $_SESSION = array();



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
            <p>Ponga aquí su publicidad </p>
            <form id='empezar'  method="POST" action="destinos.php">
                <button type="submit" value='ok' class="btn btn-primary">Empezar</button>
                <input type="hidden" name="action" value="empezar"</input>
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


