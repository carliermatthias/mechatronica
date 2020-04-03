<?php 
error_reporting(E_ALL);
ini_set('display_errors', true);

include ('includes/templates/headertemplate.php'); 

if(isset($_POST['email'])&& isset($_POST['password'])){
	$email=$db->sanitize($_POST['email']);
	$passw=$db->sanitize($_POST['password']);
	if($db->checkLogin($email,$passw)){
		session_start();
		$_SESSION['loggedin'] = TRUE;
		$_SESSION['name'] = $db->getName($email);
		$_SESSION['email'] = $_POST['email'];
		header('Location: homepage.php');
	}
}
?>

<article>
	</br></br>
	
	<div class="login_page">
            <div class="form">
			<h1>Log in</h1>
				<form class="login-form" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
					<input type="email" name="email" placeholder="email"><br><br/>
					<input type="password" name="password" placeholder="password"><br><br/>
					<?php 
					if(isset($_POST['email'])&& isset($_POST['password'])){ //this part doesn't work yet
						$email=$db->sanitize($_POST['email']);
						$passw=$db->sanitize($_POST['password']);
						if(!$db->checkLogin($email,$passw)){
							echo('<div class="errorMessage" >Invalid email or password.<br/><div>'); // TODO: CSS op errormessage
						}
					}?>
					<button type="submit">Login</button>
					<p class="message">Not registered? <a href="register.php">Create an account</a></p> 
				</form>
			</div>
        </div>
</article>
