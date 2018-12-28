<?php
	session_start();
	include("fonctions.php");
	header("Content-Type: text/plain");
	
	if(isset($_POST['source']) AND isset($_POST['destination']) AND verifRepertoire($_POST['source']) AND verifRepertoire($_POST['destination']) AND is_dir($_POST['destination'])AND $_SESSION['autorisation']==1){
		if(deplacer($_POST['source'],$_POST['destination'])){
			echo "valide";
		}else{
			echo "erreur";
		}
	}else{
		echo "erreur";
	}
?>