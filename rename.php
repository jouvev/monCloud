<?php
	session_start();
	include("fonctions.php");
	header("Content-Type: text/plain");
		
	if($_SESSION['autorisation']==1 AND isset($_GET['rep']) AND verifRepertoire($_GET['rep'])){
		if(isset($_POST['nom']) AND strlen($_POST['nom'])<51 AND !file_exists(substr($_GET['rep'],0,strrpos($_GET['rep'],'/'))."/".trim($_POST['nom']))){
			if(is_dir($_GET['rep']) AND (strpos($_POST['nom'],'.'))===FALSE){
				if(rename($_GET['rep'],substr($_GET['rep'],0,strrpos($_GET['rep'],'/'))."/".trim($_POST['nom']))){
					echo "valide";
				}
				else{
					echo "erreur";
				}
			}elseif(!is_dir($_GET['rep'])){
				if(rename($_GET['rep'],substr($_GET['rep'],0,strrpos($_GET['rep'],'/'))."/".trim($_POST['nom']))){
					echo "valide";
				}
				else{
					echo "erreur";
				}
			}
		}else{
			echo "erreur";
		}
	}else{
		echo "erreur";
	}
?>
