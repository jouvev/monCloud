<?php
	session_start();
	include("fonctions.php");
	
	if($_SESSION['autorisation']==1 AND isset($_GET['rep']) AND verifRepertoire($_GET['rep']) AND $_GET['rep']!='ftp' AND basename($_GET['rep'])!='.htaccess'){//verification 
		if(is_dir($_GET['rep'])){
			if(delTree($_GET['rep'])){
				echo "valide";
			}else{
				echo "erreur";
			}
		}
		else{
			if(unlink($_GET['rep'])){
				echo "valide";
			}else{
				echo "erreur";
			}
		}
		exit();
	}
	else{
		echo "erreur";
	}
?>

