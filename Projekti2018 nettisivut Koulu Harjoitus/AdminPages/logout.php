<?php
	session_start();
    session_destroy(); 
	
	echo "You are logged Out";

	header("Location: ../etusivu.php"); /* Redirect browser */
exit();
?>