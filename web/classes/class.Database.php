<?php 


	// This path should point to Composer's autoloader
	require 'vendor/autoload.php';
	require 'config.php';



	class Database {

		var $mdb 		  = '';
		var $databaseName = '';

		function Database ( $dbhost, $dbname, $dbauth ) {
			// Specifying the username and password via the options array (alternative)
			$this -> mdb = new MongoDB\Client("mongodb://$dbhost", $dbauth);
			$this -> databaseName = $dbname;



		}

		

		function getDestinos () {

			$dbname = $this -> databaseName;


			$collection = $this ->mdb->$dbname->destino;
			$allDestinos =  ($collection->find());

			#Tipos de destinos en la bd:
			$tipos = array();

			#creamos un diccionario con el tipo (CCAA, provincia...) y dentro el destino con todos sus datos:
			foreach ($allDestinos as $col) {
				$tipos[$col['tipo']][] =[$col['destino'],$col['destino_normalizado'], $col['iddestino']];
			}

			return $tipos;


		}

		function getConsultas () {

			$dbname = $this -> databaseName;


			$collection = $this ->mdb->$dbname->consulta;
			return ($collection->find());


		}

		#diferentes tipos de busquedas (organic, questions, topbar, images...)
		function getBusquedaTypeDistinct () {
			$dbname = $this -> databaseName;


			$collection = $this ->mdb->$dbname->busqueda;
			return ($collection->distinct("Type"));
			
		}

		function getBusquedasFilter ($listConsultas, $listDestinos, $listTipos ) {
			$dbname = $this -> databaseName;

			$queryDestino   = array('iddestino' => array( '$in' => $listDestinos));
			$queryConsultas = array('idconsulta' => array( '$in' => $listConsultas));
			$queryTipos		= array('Type' => array( '$in' => $listTipos));

			/*print_r ($queryDestino);
			print '-----';
			print_r ($queryConsultas);
			print '-----';
			print_r ($queryTipos);
			exit();*/
			#$queryResult	= array('')

			$queryFinal 	= array ('$and' => array ($queryDestino, $queryConsultas, $queryTipos));

			$collection = $this ->mdb->$dbname->busqueda;

			return ($collection->find ( $queryFinal ));



		}

		function searchQuery ( $query ) {

			$dbname = $this -> databaseName;


			$collection = $this ->mdb->$dbname->busqueda;

			$regex = new MongoDB\BSON\Regex ( '^' . 'desktop' . '^' );
			
			$where = array("Query" => new MongoDB\BSON\Regex ($query,'i'));
			#$consulta = array('Query' => $regex );

			#,['limit' => 10] )

			return   ($collection->find( $where));


		}



		function getCategorias () {

			$dbname = $this -> databaseName;


			$collection = $this ->mdb->$dbname->categoria;
			$allCats =  ($collection->find());

			$tipos = array();

			#creamos un diccionario con la categoria (informacional...) y dentro la categoria con todos sus datos:
			foreach ($allCats as $col) {
				$tipos[$col['CatPrincipal']][] =[$col['consulta'],$col['idcategoria']];
			}

			return $tipos;
			


		}

		function getConsultasPorCategoria ( $listCategorias ) {

			$dbname = $this -> databaseName;
			
			
			$collection = $this ->mdb->$dbname->consulta;
			return ($collection->find(array('categorias' => array( '$in' => $listCategorias))));
			

		}

		function getTotalBusquedas () {

			if (isset ($this -> numBusquedas)) {

				return $this -> numBusquedas;
			}

			$dbname = $this -> databaseName;

			$collection = $this ->mdb->$dbname->busqueda;

			$this -> numBusquedas = $collection->count();
			 return $this -> numBusquedas;
		}

		function getBusquedasDestino ( $iddestino, $skip, $limit ) {
			$dbname = $this -> databaseName;


			$collection = $this ->mdb->$dbname->busqueda;

			#$query = array ('iddestino'=>$iddestino, 'Position'=>"'1'");
			$query = array ('iddestino'=>(int)$iddestino, 'Position'=>"1");

			$data = $collection->find( $query, [ 'limit' => $limit, 'skip' => $skip ] );
			
			return ($data);

		}

		function getBusquedasConsulta ( $idcategoria, $skip, $limit ) {
			$dbname = $this -> databaseName;


			$collection = $this ->mdb->$dbname->busqueda;

			#$query = array ('iddestino'=>$iddestino, 'Position'=>"'1'");
			$query = array ('idconsulta'=>(int)$idcategoria, 'Position'=>"1");

			$data = $collection->find( $query, [ 'limit' => $limit, 'skip' => $skip ] );
			
			return ($data);

		}

		function getBusqueda ( $idbusqueda ) {

			$dbname = $this -> databaseName;


			$collection = $this ->mdb->$dbname->busqueda;

			#$query = array ('iddestino'=>$iddestino, 'Position'=>"'1'");

			$query = array ('ID'=>$idbusqueda );

			$data = $collection->find( $query );
			
			return ($data);


		}

	}


?>	