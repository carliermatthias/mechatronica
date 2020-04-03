<?php
session_start();
require 'includes/config/cmdlist.php';
$cmd=cmdlist::getInstance();
	
if($_SESSION["loggedin"])
	{
	 include ('includes/templates/headertemplate_route.php');
	 if(isset($_POST['name'])){
     print($_POST['name']);
		 $name=$db->sanitize($_POST['name']);
     print($name);
     print($_SESSION['email']);
		 $db->addRoute($_SESSION['email'],$name);
		 header('Location: homepage.php');
	 } 

?>
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