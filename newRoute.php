<?php
session_start();
require 'includes/config/cmdlist.php';
$cmd=cmdlist::getInstance();
	
if($_SESSION["loggedin"])
	{
	 include ('includes/templates/headertemplate.php');
	 if(isset($_POST['name'])){
     print($_POST['name']);
		 $name=$db->sanitize($_POST['name']);
     print($name);
     print($_SESSION['email']);
		 $db->addRoute($_SESSION['email'],$name);
		 header('Location: homepage.php');
	 } 

?>
<div class="topnav" id="myTopnav">
  <a href="homepage.php" >Home</a>
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

<div class="modal-content">
	<div class="container-header">
		<h1>Make new route</h1>
		<p style="font-size:15px;line-height:0px;">Give your new route a name and start adding instructions to it
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">

	<br>
	<input type="text" name="name" placeholder="Route name"><br><br>
	<button type="submit">Add new route</button>
	<p class="message"><a href="homepage.php">Back</a></p>
	</form>
</div>    


<?php
include ('includes/templates/footertemplate.php');
}

else
{
	include ('includes/templates/not_logged_in.php'); 
}
?>