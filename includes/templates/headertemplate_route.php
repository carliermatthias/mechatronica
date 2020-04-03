
<?php	
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