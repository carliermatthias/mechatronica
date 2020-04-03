<?php
	// Opnieuw aangeven dat je sessies wil gebruiken.
	// Deze lijn moet bovenaan.
	session_start();
	session_unset();
	session_destroy();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Project mechatronica</title>
    </head>

<body>

    <p>U bent uitgelogd.</p>
    <p>Klik <a href="index.php"> hier </a> om opnieuw in te loggen."</p>

</body>
</html>