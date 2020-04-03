<?php
session_start();
include ('includes/config/cmdlist.php'); 
$cmd=cmdlist::getInstance();
$cmdlist=$cmd->getCommandlist($_SESSION['routeId']);
	if($_SESSION["loggedin"])
		{
			include ('includes/templates/headertemplate_route.php'); 

			?>
			
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