          <div class="table-responsive">
                      <table id="example" class="table" cellspacing="0" width="100%">
                          <thead class="thead-dark">
                              <tr>
                                  <th>Consulta</th>
                                   <th>Categorías</th>
                                   <th></th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php

                                    $db = new Database ($DB_HOST , $dbname, array("username" => $DB_USER, "password" => $DB_PWD) );

                                    $result = $db->getConsultas ();

                                    foreach ($result as $entry) {                                      
                                          $listaCats = '';

                                          foreach ($entry['categoriasText'] as $cat){
                                              $listaCats = $listaCats . '|' . $cat;
                                          }

                                          $listaCats = $listaCats . '|';

                                  	 	   echo '<tr>
                                                          <td>' . $entry['consulta'] . '</td>
                                                          <td>' .  $listaCats . '</td>
                                  	 	   		<td> 
                                                <form method="POST" action="busquedas.php">                                	 	   		  
                                    	 	   			   <input type="hidden" name="idconsulta" value="'. $entry['idconsulta']  .' ">	
                                                                        <a href="#" onclick="$(this).closest(\'form\').submit()"><i class="fa fa-paper-plane"></i></a>
                                  	 	   		    </form>
                                  	 	   	      </td>
                                  	 	   	</tr>
                                  	 	   		';
                                    }
                              ?>      
                              </tbody>                            
                        </table>
          </div>
