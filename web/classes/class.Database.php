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