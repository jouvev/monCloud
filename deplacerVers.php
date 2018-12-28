<?php
session_start();

include("fonctions.php");
?>
<!DOCTYPE html>
<html>
    <head>
		<title>Chemin</title>
		<link rel="stylesheet" href="css/styleDeplacer.css">
		<script src="js/script.js"></script>
    </head>
   
   <body>
<?php
		if($_SESSION['autorisation']==1 AND isset($_GET['rep']) AND verifRepertoire($_GET['rep']) AND is_dir($_GET['rep']) AND isset($_GET['aDeplacer']) AND verifRepertoire($_GET['aDeplacer']))
		{
			$dossier=$_GET['rep'];
			$elemADeplacer = $_GET['aDeplacer'];
?>
		
		<div id="main">
		
<?php
	echo "\t\t\t<p>".substr($dossier,4)."</p>\n";
	
?>
<?php
			echo "\t\t\t\t<ul>\n";
			$tabTree = scandir($dossier);
			if($dossier !='ftp'){
				echo "\t\t\t<li><img src=\"image/up.png\"><a href=\"deplacerVers.php?rep=".substr($dossier,0,strrpos($dossier,'/',-1))."&aDeplacer=$elemADeplacer\">Repertoire précédent</a></li>\n";
			}
			foreach($tabTree as $elem){ //affichage du contenue du dossier 
							
				if($elem!='.'&& $elem!='..' && $elem!='.htaccess'){//on retire les fichiers qu'on ne veut pas afficher
					$cheminVersElem= $dossier."/".$elem; //chemin vers element qu'on traite
								
					if(is_dir($cheminVersElem) AND strcmp($elemADeplacer,substr($cheminVersElem,0,strlen($elemADeplacer)))!==0){
						echo "\t\t\t\t\t<li><img src=\"image/folder.png\"><a href =\"deplacerVers.php?rep=$cheminVersElem&aDeplacer=$elemADeplacer\">$elem</a></li>\n";
					}
				}
			}
			echo "\t\t\t\t</ul>\n";
		}
?>
		</div>
<?php
		if($dossier != substr($elemADeplacer,0,strrpos($elemADeplacer,'/',-1))){
			echo "<div id=\"menu\"><button onclick=\"deplacerVers('$elemADeplacer','$dossier')\">Déplacer ici</button></div>";
		}
?>
    </body>
</html>
