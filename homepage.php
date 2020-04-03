<?php
include ('includes/templates/headertemplate.php'); 
		session_start();
		if(!empty($_SESSION['name'])){
			$email = $_SESSION['email'];
			$name = $_SESSION['name'];		
		}
    		
		if(!empty($_SESSION["loggedin"]) && $_SESSION["loggedin"])
		{
			?>
			<div class="topnav" id="myTopnav">
			<a href="homepage.php" class="active">Home</a>
			<a href="newRoute.php">Add New Route</a>
			<a href="livepage.php">Live Traject Page</a>
			<a href="">Sensor Data</a>
			<a href="settings.php">Account Settings</a>
			<a href="javascript:void(0);" class="icon" onclick="myFunction()">
				<i class="fa fa-bars"></i>
			</a>
			</div>

			<script>
			function myFunction() {
			var x = document.getElementById("myTopnav");
			if (x.className === "topnav") {
				x.className += " responsive";
			} else {
				x.className = "topnav";
			}
			}
			</script>

							<div class="container-header">
								<h1>Welcome, <?php echo($name) ?></h1>
								<p style="line-height:0px;">In this menu, you can select your designed routes.</p>
							</div>
							
							<?php
                if(isset($_POST['delete-id'])){
                  $db->deleteRoute($_POST['delete-id']);
                };

								if(isset($_POST['adapted_array']) & isset($_POST['route_id']) ){
									$data = $_POST['adapted_array'];
									$json = json_decode($data);
									$dbFormat = implode(";", $json);
									$dbFormat .= ";";

									$id = $_POST['route_id'];

									$db->updateRoute($id,$dbFormat);
									
									unset($_POST['adapted_array']);
									unset($_POST['route_id']);

								};
							?>

							<?php
								$routes = $db->getRoutes($email);
								
								foreach($routes as $route){	
								$commands = $route->commands;
								$commandarray = array_filter(explode(";",$commands));
							?>				
									<script>
										<?php
											$js_array = json_encode($commandarray);

											echo "var command_array{$route->id} =".$js_array.";\n";
											

										?>
										console.log(command_array<?php echo $route->id;?>);
										
										function updateHiddenBox_<?php echo $route->id;?>(){
											document.getElementById('hidden-text<?php echo $route->id;?>').value = JSON.stringify(command_array<?php echo $route->id;?>);
										}

										function deleteIndex_<?php echo $route->id;?>(){
											var selected_id = document.getElementById("select_id_<?php echo $route->id;?>").value
											command_array<?php echo $route->id;?>.splice(selected_id,1);									
											var arr_length = command_array<?php echo $route->id;?>.length;
											var textarea_array<?php echo $route->id;?> = [];
											

											var i;
											for (i = 0; i < arr_length;  i++) {
												textarea_array<?php echo $route->id;?>[i] = i+") "+command_array<?php echo $route->id;?>[i]
											};
											function ClearOptions()
											{
												document.getElementById("select_id_<?php echo $route->id;?>").options.length = 0;
											}

											function update_ComboBox(length){
												ClearOptions() 									
												for(var i = 0; i < length; i++){
													var option = document.createElement("option");
													option.text = i;	
													option.value = i;
													var select = document.getElementById("select_id_<?php echo $route->id;?>");
													select.appendChild(option);
												}
												

											};											

											document.getElementById('textarea_<?php echo $route->id;?>').value = textarea_array<?php echo $route->id;?>.join("\n")
											update_ComboBox(arr_length);
											updateHiddenBox_<?php echo $route->id;?>();
										};

										function addItem_<?php echo $route->id;?>(){
											var selected_seconds = document.getElementById("select_seconds_<?php echo $route->id;?>");
											var selected_direction = document.getElementById("select_direction_<?php echo $route->id;?>");

											command_array<?php echo $route->id;?>.push(selected_direction.value+","+selected_seconds.value);

											var arr_length = command_array<?php echo $route->id;?>.length;
											var textarea_array<?php echo $route->id;?> = []

											var i;
											for (i = 0; i < arr_length;  i++) {
												textarea_array<?php echo $route->id;?>[i] = i+") "+command_array<?php echo $route->id;?>[i]
											};

											function ClearOptions()
											{
												document.getElementById("select_id_<?php echo $route->id;?>").options.length = 0;
											}

											function update_ComboBox(length){
												ClearOptions() 									
												for(var i = 0; i < length; i++){
													var option = document.createElement("option");
													option.text = i;	
													option.value = i;
													var select = document.getElementById("select_id_<?php echo $route->id;?>");
													select.appendChild(option);
												}

											};	

											document.getElementById('textarea_<?php echo $route->id;?>').value = textarea_array<?php echo $route->id;?>.join("\n")
											update_ComboBox(arr_length);
											updateHiddenBox_<?php echo $route->id;?>();
										};

										function discard_<?php echo $route->id;?>(){
											var command_array_original<?php echo $route->id;?> = [];
											<?php
											echo "command_array_original{$route->id} =".$js_array.";\n";
											?>
											
											command_array<?php echo $route->id;?> = [];
											command_array<?php echo $route->id;?> = command_array_original<?php echo $route->id;?>;
											var arr_length = command_array<?php echo $route->id;?>.length;
											var textarea_array<?php echo $route->id;?> = []

											var i;
											for (i = 0; i < arr_length;  i++) {
											textarea_array<?php echo $route->id;?>[i] = i+") "+command_array<?php echo $route->id;?>[i]
											};

											function ClearOptions()
											{
											 	document.getElementById("select_id_<?php echo $route->id;?>").options.length = 0;
											};

											function update_ComboBox(length){
												ClearOptions() 									
												for(var i = 0; i < length; i++){
													var option = document.createElement("option");
													option.text = i;	
													option.value = i;
													var select = document.getElementById("select_id_<?php echo $route->id;?>");
													select.appendChild(option);
												};
											};
											document.getElementById('textarea_<?php echo $route->id;?>').value = textarea_array<?php echo $route->id;?>.join("\n")
											update_ComboBox(arr_length);
											updateHiddenBox_<?php echo $route->id;?>();
										};
                                                                   
                                                                   
                                                                   
                                                                   
                   function sleep(ms) {
                      return new Promise(resolve => setTimeout(resolve, ms));
                   }
                   
                   function sendRequest(page){
                    var request = new XMLHttpRequest();
                    request.open("GET", page);
                    request.onreadystatechange=function(){
                        if(request.readyState==4){
                            if(request.status==200){
                            } else alert ("HTTP error");
                        }
                    }
                    request.send();
                  }
              
                  async function execute_<?php echo $route->id;?>() {
											var command_array_original<?php echo $route->id;?> = [];
											<?php
											echo "command_array_original{$route->id} =".$js_array.";\n";
											?>
                      var cmd_array;
                      var command;
                      var time;
                      var count;
                      var arrayLength = command_array_original<?php echo $route->id;?>.length;
                      for (var i = 0; i < arrayLength; i++) {
                          var cmd_array = command_array_original<?php echo $route->id;?>[i].split(",")
                          command = cmd_array[0];
                          time = parseInt(cmd_array[1])*1000;
                          
                          if (command =="forward"){
                            sendRequest("/gpio_control/up.php");
                          } else if(command == "backward"){
                            sendRequest("/gpio_control/down.php");                         
                          } else if(command == "left"){
                            sendRequest("/gpio_control/left.php");
                          } else if(command == "right"){
                            sendRequest("/gpio_control/right.php");
                          } else if(command == "rotate left"){
                            sendRequest("/gpio_control/rotate_left.php");
                          } else if(command == "rotate right"){
                            sendRequest("/gpio_control/rotate_right.php");
                          }
                          
                          
                          count = count +1;
                          await sleep(time);
                      }
              
                      if (count = arrayLength){
                          sendRequest("/gpio_control/stop.php");
                      }
                  }
		
									</script>
			
		
									<div class='card'>
									<div class='container'>
										<h4><b><?php echo $route->name; ?></b></h4>
									</div>
									<button class='play-symbol' id="PLAY_<?php echo $route->id;?>" onclick="execute_<?php echo $route->id;?>()">&#9658;</button>
									<button class='pause-symbol' id="PAUSE_<?php echo $route->id;?>" onclick="alert('TODO: ADD PAUSE FUNCTIONALITY')">&#10074;&#10074;</button>
									<button class='settings-symbol' id="myBtn_<?php echo $route->id;?>">&#9881;</button>
                  <form action="homepage.php" method="post">
                    <input type="text" name="delete-id" value="<?php echo $route->id;?>" style="visibility:hidden;height:0px;width:0px;"></input>
                    <input style="margin-top:-6px;"type="submit" value="&#128465;" class='delete-symbol' id="DELETE_<?php echo $route->id;?>" onclick=""></input> 
                  </form>                                                   
									</div>
									
									<div id="myModal_<?php echo $route->id;?>" class="modal">

										<!-- Modal content -->
										<div class="modal-content">
											<span class="close_<?php echo $route->id;?>" id="close">&times;</span>
											<H2 style="text-align:center;"><?php echo $route->name;?></p>
											<p style="font-size:15px;text-align:center;">Current command</p>
											<textarea readonly id="textarea_<?php echo $route->id;?>" style="text-align:left;border:none;overflow-y: scroll;height: 80px;width:60%; resize: none;overflow:auto;"><?php $i=0; foreach ($commandarray as $commando){echo "{$i}) {$commando}&#13;&#10;"; $i++;}; ?></textarea>
											<div style="float:left;width:50%;">
												<p style="font-size:15px;text-align:center;">Add a new command</p>
												<select id="select_direction_<?php echo $route->id;?>" style="width:90px;">
													<option value="forward">forward</option>
													<option value="backward">backward</option>
													<option value="left">left</option>
													<option value="right">right</option>
          	              <option value="rotate left">rotate left</option>
                        	<option value="rotate right">rotate right</option>                                                                                                                                 
												</select></br>
												<div>
													<select id="select_seconds_<?php echo $route->id;?>" style="display:inline-block;">
														<option value="1">1</option>
														<option value="2">2</option>
														<option value="3">3</option>
														<option value="4">4</option>
														<option value="5">5</option>
													</select>
													<p style="font-size:10px;display:inline-block;margin-right:10px;">seconds</p>
												</div>
												<div style="padding: 5px;">
													<button class="btn-add" onclick="addItem_<?php echo $route->id;?>()">ADD</button>
												</div>
											</div>
											<div style="float:right;width:50%;">
												<p style="font-size:15px;text-align:center;">Remove a command</p>
												<select id="select_id_<?php echo $route->id;?>">
													<?php
														$ii = 0;
														foreach($commandarray as $commando){
															echo "<option value=\"{$ii}\">{$ii}</option>";
															$ii++;
														};
													?>
												</select>
												<button class="btn-delete" onclick=" deleteIndex_<?php echo $route->id;?>()">DELETE</button>
											</div>
											<form action="homepage.php" method="post">
												<input style="visibility: hidden; width:0px;height:0px;" id="hidden-text<?php echo $route->id;?>"  name="adapted_array" type="text" ></input>
												<input style="visibility: hidden; width:0px;height:0px;" id="route_id_hidden<?php echo $route->id;?>" name="route_id" type="text" value="<?php echo $route->id;?>"></input>
												<input	id ="save_changes<?php echo $route->id; ?>" class="save-button" type="submit" value="Save Changes"></input>
											</form>
											<div style="clear:both; margin:5px;">
												<button class="discard-button" onclick="discard_<?php echo $route->id;?>()">Discard Changes</button>
											</div>
							
										</div>
											
										</div>

										<script>
											var modal_<?php echo $route->id;?>= document.getElementById("myModal_<?php echo $route->id;?>");
											var btn_<?php echo $route->id;?> = document.getElementById("myBtn_<?php echo $route->id;?>");
											var span_<?php echo $route->id;?> = document.getElementsByClassName("close_<?php echo $route->id;?>")[0];
											
											document.getElementById('hidden-text<?php echo $route->id;?>').value = JSON.stringify(command_array<?php echo $route->id;?>);

											btn_<?php echo $route->id;?>.onclick = function() {
											modal_<?php echo $route->id;?>.style.display = "block";
											}
											span_<?php echo $route->id;?>.onclick = function() {
											modal_<?php echo $route->id;?>.style.display = "none";
											}
											window.onclick = function(event) {
											if (event.target == modal_<?php echo $route->id;?>) {
												modal_<?php echo $route->id;?>.style.display = "none";
											}
											}
										</script>

									
							<?php
								};
							?> 
               <p id="array-value"></p>
							

							
                       
			<?php
			include ('includes/templates/footertemplate.php'); 
		}      
        else
			{
				include ('includes/templates/not_logged_in.php');
			}
?>