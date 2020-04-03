<?php
session_start();
include ('includes/config/cmdlist.php'); 
$cmd=cmdlist::getInstance();
$cmdlist=$cmd->getCommandlist($_SESSION['routeId']);
	if($_SESSION["loggedin"])
		{
			include ('includes/templates/headertemplate.php'); 

			?>
			<div class="topnav" id="myTopnav">
			<a href="homepage.php">Home</a>
			<a href="newRoute.php" class="active">Add New Route</a>
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
				<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
					<select name="command">
						<option value="forward">Forward</option>
						<option value="backward">Backward</option>
						<option value="left">Turn left</option>
						<option value="right">Turn right</option>
						<option value="stop">Stop</option>
					</select><br>
					<input type="text" name="seconds" placeholder="time"><br>
					<button type="submit">Add command</button>
				</form>
				<br>
				<h1>Current commands</h1>
				<hr>
                <table>
					<tr>
						<th>Command</th>
						<th>Time</th>
						<th>Delete</th>
					</tr>
					<?php
						for ($i=0;$i<count($cmdlist);$i++){?> 
						<tr>
							<td><?php $cmdlist[$i][0] ?></td>
							<td><?php $cmdlist[$i][1] ?></td>
							<td><button>delete</button></td>
						</tr>
							<?php
					   
						}
					?>
				</ul>	    


			<?php
			include ('includes/templates/footertemplate.php');
		}
        
        else
			{
				include ('includes/templates/not_logged_in.php'); 
			}
?>