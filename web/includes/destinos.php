          <div class="table-responsive">
                      <table id="example" class="table" cellspacing="0" width="100%">
                          <thead class="thead-dark">
                              <tr>
                                  <th>Destino</th>
                                  <th>Destino normalizado</th>
                                   <th></th>
                              </tr>
                          </thead>
                          <tbody>
                              <?php

                                    $db = new Database ($DB_HOST , $dbname, array("username" => $DB_USER, "password" => $DB_PWD) );

                                    $result = $db->getDestinos ();

                                    foreach ($result as $entry) {
                              	 	   echo '<tr>
                                                      <td>' . $entry['destino'] . '</td>
                                                      <td>' . $entry['destino_normalizado'] . '</td>
                              	 	   		<td> 
                              	 	   		    <form method="POST" action="busquedas.php">  
                              	 	   			   <input type="hidden" name="iddestino" value="'. $entry['iddestino']  .' ">	
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
