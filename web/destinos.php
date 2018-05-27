<?php
    include_once ("includes/genericheader_navegacion.php");
?>

    <!-- Page Content -->
    <div class="container">
      <h1 class="mt-5">Seleccione un destino</h1>
      <?php
            include_once ("classes/class.Database.php");
            require ("config.php");
            session_start(); 

            #tomamos los destinos de la bd
            $dbname = 'TuristOMaticUK';
            #,"ssl" => false
            $db = new Database ($DB_HOST , $dbname, array("username" => $DB_USER, "password" => $DB_PWD) );
            $destinosPorTipo = $db->getDestinos ();

            /*En la base de datos aparece como CCAA, para hacelro lo más genérico posible se leen esos valores y se muestran 
            en pantalla, de esta forma si se cambian esos valores no se cambia nada de la web.
            Sin embargo, cosas de la vida, quieren que el campo CCAA se sustituya por comunidades autónomas. Con este apaño
            se hace eso, pero lo pongo dentro de un try por si acaso en la base de datos no aparece tal cosa en el futuro:*/
            
            try {
              $ccaa = $destinosPorTipo['CCAA'];
              unset ($destinosPorTipo['CCAA']);
              #Si se hace de esta forma nos aseguramos que comunidades autónomas aparezca al principio del array:
              $destinosPorTipo = array ('Comunidades Autónomas' => $ccaa) + $destinosPorTipo;
            }catch (Exception $e) {

            }
            /*Lo mismo nos pasa con Internacional, aunque esta debe estar al final de la lista*/
            try {
              $internacional = $destinosPorTipo['Internacional'];
              unset ($destinosPorTipo['Internacional']);
              
              $destinosPorTipo = $destinosPorTipo + array ('Ciudades internacionales' => $internacional);
            }catch (Exception $e) {

            }
            

            include ('includes/acordeonDestinos.php');

      ?>
    </div>
    <!-- /.container -->

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>