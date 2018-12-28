<?php
	session_start();

	if(isset($_SESSION['autorisation']) AND $_SESSION['autorisation']==1){
		unset($_SESSION['autorisation']);
		header("Location:index.php");
		exit();
	}
?>