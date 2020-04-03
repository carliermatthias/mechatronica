<?php
session_start();
require 'includes/config/cmdlist.php';
$cmd=cmdlist::getInstance();
	
if($_SESSION["loggedin"])
	{
	 include ('includes/templates/headertemplate.php');
	 $id = $db->getId($_SESSION['email']);
	 

?>
<div class="topnav" id="myTopnav">
  <a href="homepage.php" >Home</a>
  <a href="newRoute.php">Add New Route</a>
  <a href="livepage.php">Live Traject Page</a>
  <a href="">Sensor Data</a>
  <a href="settings.php" class="active">Account Settings</a>
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
		<h1>Account Settings</h1>
		
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
	<br>

		<p>Change Email</p>
		<input type="email" name="email" placeholder="Email"><br><br>
		<input type="email" name="email2" placeholder="Confirm Email"><br><br>
		<?php 
					if(isset($_POST['email'])&&isset($_POST['email2'])&&!($_POST['email']=='')){
						if($_POST['email']==$_POST['email2']){
						   $email=$db->sanitize($_POST['email']);
						   if($db->checkEmail($email)){
							   $db->editEmail($id,$email);
							   $_SESSION['email'] = $email;
						   } else {
							   echo('<div class="errorMessage" >Email already in use!<br/></div>'); 
						   }
						} else {
							echo('<div class="errorMessage" >Emails do not match!<br/></div>'); 
						}
				   
				} else {
					echo('<div class="errorMessage" >All fields of this section need to be filled in!<br/></div>'); 
				}
		?>
		
		<button type="submit">Save changes</button>
		</form>
		<hr>
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
		<p>Change password</p>
		<input type="password" name="passwd" placeholder="New password"><br><br>
		<input type="password" name="passwd2" placeholder="Re-type password"><br><br>
		<input type="password" name="oldpasswd" placeholder="Old password"><br><br>
		<?php 
					if(isset($_POST['passwd'])&&isset($_POST['passwd2'])&&isset($_POST['oldpasswd'])){
						if($_POST['passwd']==$_POST['passwd2']){
							$ww = $db->sanitize($_POST['oldpasswd']);
							if($db->checkLogin($_SESSION['email'],$ww)){
								$passwd=$db->sanitize($_POST['passwd']);
						   		$db->editPassword($id,$passwd);
							} else {
								echo('<div class="errorMessage" >Wrong old password!<br/></div>'); 
							}
						   
						} else {
							echo('<div class="errorMessage" >Passwords do not match!<br/></div>'); 
						}
				   
					}  else {
						echo('<div class="errorMessage" >All fields of this section need to be filled in!<br/></div>'); 
					}
		?>
		
		<button type="submit">Save changes</button>
		</form>
		<hr>
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
		<p>Change Username</p>
		<input type="text" name="username" placeholder="Username"><br><br>
		<?php 
					if(isset($_POST['username'])){
						
						$name=$db->sanitize($_POST['username']);
						$db->editUsername($id,$name);
						$_SESSION['name'] = $name;
						
				   
				} else {
					echo('<div class="errorMessage" >All fields of this section need to be filled in!<br/></div>'); 
				}
		?>
		
		<button type="submit">Save changes</button>
		</form>
		<hr>

	<p class="message"><a href="homepage.php">Back</a></p>
</div>    


<?php
include ('includes/templates/footertemplate.php');
}

else
{
	include ('includes/templates/not_logged_in.php'); 
}
?>