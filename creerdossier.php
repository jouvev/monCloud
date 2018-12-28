<?php
	session_start();
	include("fonctions.php");
	header("Content-Type: text/plain");

	if($_SESSION['autorisation']==1 AND isset($_GET['rep']) AND verifRepertoire($_GET['rep']) AND is_dir($_GET['rep'])){//si on a les autorisation 
		if(isset($_POST['nom']) AND strlen($_POST['nom'])<51 AND (strpos($_POST['nom'],'.'))===FALSE AND !file_exists($_GET['rep']."/".trim($_POST['nom']))){//si le nom est valide 
			if(mkdir($_GET['rep']."/".trim($_POST['nom']),0777)){//creation et on verifie que tout c'est bien passe
				echo "valide";
			}
			else{
				echo "erreur";
			}
			exit();
		}else{
			echo "erreur";
		}
	}else{
		echo "erreur";
	}
?>