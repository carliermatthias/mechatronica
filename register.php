<?php 
include ('includes/templates/headertemplate.php'); 

if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password2']) && $db->checkEmail($_POST['email']) && ($_POST['password'] == $_POST['password2'])){
	$name=$db->sanitize($_POST['name']);
	$passw=$db->sanitize($_POST['password']);
	$email=$db->sanitize($_POST['email']);
	if($db->addStandardUser($name,$passw, $email)){
		header('Location: index.php'); 
	}
}
?>

<article>
	</br></br>
	
	<div class="login_page">
            <div class="form">
			<h1>Register</h1>
				<form class="login-form" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
					<input type="email" name="email" placeholder="email"><br><br/>
					<input type="name" name="name" placeholder="name"><br><br/>
					<input type="password" name="password" placeholder="password"><br><br/>
					<input type="password" name="password2" placeholder="re-type password"><br><br/>
					<?php 
					if(isset($_POST['name'])&& isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['email'])){ //this part doesn't work yet
						$name=$db->sanitize($_POST['name']);
						$email=$db->sanitize($_POST['email']);
						$check = !$db->checkEmail($email);
						$passw=$db->sanitize($_POST['password']);
						$passw2=$db->sanitize($_POST['password2']);
						if($check){
							echo('<div class="errorMessage" >Email already in use.<div>'); // TODO: CSS op errormessage
						}
						if($passw != $passw2){
							echo('<div class="errorMessage" >Passwords did not match.<br/><div>'); // TODO: CSS op errormessage
						}
					}?>
					<button type="submit">Register</button>
					
				</form>
			</div>
        </div>
</article>

<?php

include ('includes/templates/footertemplate.php');

?>