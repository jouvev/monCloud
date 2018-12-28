<?php
session_start();

include("fonctions.php");
?>
<!DOCTYPE html>
<html>
    <head>
		<title>Upload</title>
		<link rel="stylesheet" href="css/styleFormUpload.css">
		<script src="js/script.js"></script>
    </head>
   
   <body>
		<div class="menu">
			<a href="deconnexion.php"><img src="image/deco.png" style="padding-right:5px;">Déconnexion</a>
		</div>
		
		<?php
		$extensionLecture=array('.c','.h','.java','.py','.txt','.php','.pdf','.jpg', '.jpeg', '.png', '.bmp', '.gif');

		if(isset($_GET['rep']) AND verifRepertoire($_GET['rep']) AND is_dir($_GET['rep'])){
			$dossier=$_GET['rep'];
		}
		else{
			$dossier='ftp';
		}

		if($_SESSION['autorisation']==1)
		{
			if(isset($_FILES['fichier'])){
				$etatUpload = upload($dossier);
			}
		?>
		
		<div id="main">
		
<?php
	echo "\t\t\t<h1>".substr($dossier,4)."</h1>\n";
	if($dossier != 'ftp'){
		echo "\t\t\t<img id=\"back\" src=\"image/up.png\"><a href=\"formUpload.php?rep=".substr($dossier,0,strrpos($dossier,'/',-1))."\">Repertoire précédent</a>\n";
	}
	echo "\t\t\t<img id =\"add\" src= \"image/add-folder.png\"><a href=\"\" onclick=\"nouveauDossier('$dossier')\">Ajouter dossier</a>\n";
?>
			<table>
				<tr>
					<th>Nom</th>
					<th>Download</th>
					<th>Taille</th>
					<th>Supprimer</th>
				</tr>
<?php
	$tabTree = scandir($dossier);
			
	foreach($tabTree as $elem){ //affichage du contenue du dossier 
					
		if($elem!='.'&& $elem!='..' && $elem!='.htaccess'){//on retire les fichiers qu'on ne veut pas afficher
			$cheminVersElem= $dossier."/".$elem; //chemin vers element qu'on traite
						
			echo "\t\t\t\t<tr>\n";
						
			if(is_dir($dossier."/".$elem)){
				echo "\t\t\t\t\t<td class =\"nom\"><div><img src=\"image/folder.png\"><a href =\"formUpload.php?rep=$cheminVersElem\">$elem</a></div><div><a style=\"padding-right:0px;\" href=\"\" onclick=\"rename('$cheminVersElem')\"><img src=\"image/rename.png\"></a><a style=\"padding-right:0px;\" href=\"\" onclick=\"deplacer('$dossier','$cheminVersElem')\"><img src=\"image/deplacer.png\"></a></div></td>\n";
				echo "\t\t\t\t\t<td class=\"download\"><a href=\"telecharger.php?rep=$cheminVersElem\"><img src=\"image/download.png\"></a></td>\n";
				echo "\t\t\t\t\t<td></td>\n";
				echo "\t\t\t\t\t<td class=\"delete\"><a href=\"\" onclick=\"supprimer('$cheminVersElem')\"><img src=\"image/delete.png\"></a></td>\n";
			}
			else{
				$extension=substr($elem,strrpos($elem,'.'));
				
				if(in_array($extension,$extensionLecture) or strrpos($elem,'.')===False){
					echo "\t\t\t\t\t<td class =\"nom\"><div><img src=".cheminIcon($extension)."><a href=\"lecture.php?rep=$cheminVersElem\">$elem</a></div><div><a style=\"padding-right:0px;\" href=\"\" onclick=\"rename('$cheminVersElem')\"><img src=\"image/rename.png\"></a><a style=\"padding-right:0px;\" href=\"\" onclick=\"deplacer('$dossier','$cheminVersElem')\"><img src=\"image/deplacer.png\"></a></div></td>\n";
				}else{
					echo "\t\t\t\t\t<td class =\"nom\"><div><img src=".cheminIcon($extension)."><a href=\"\">$elem</a></div><div><a style=\"padding-right:0px;\" href=\"\" onclick=\"rename('$cheminVersElem')\"><img src=\"image/rename.png\"></a><a style=\"padding-right:0px;\" href=\"\" onclick=\"deplacer('$dossier','$cheminVersElem')\"><img src=\"image/deplacer.png\"></a></div></td>\n";
				}
	
				echo "\t\t\t\t\t<td class=\"download\"><a href=\"telecharger.php?rep=$cheminVersElem\"><img src=\"image/download.png\"></a></td>\n";
				echo "\t\t\t\t\t<td>".convertionTaille(filesize($cheminVersElem))."</td>\n";
				echo "\t\t\t\t\t<td class=\"delete\"><a href=\"\" onclick=\"supprimer('$cheminVersElem')\"><img src=\"image/delete.png\"></a></td>\n";
				if(substr($elem,strpos($elem,'.'))=='.tar.gz'){
					echo "\t\t\t\t\t<td><a href=\"decompress.php?rep=$cheminVersElem\"'><img src=\"image/untar.png\"></a></td>\n";
				}	
			}
			echo "\t\t\t\t</tr>\n";
		}
	}
?>
			</table>

<?php
	echo "\t\t\t<form action=\"formUpload.php?rep=$dossier\" method=\"post\" enctype=\"multipart/form-data\">\n";
?>
				<input class="fichier" type="file" name="fichier">
				<input type="hidden" name="MAX_FILE_SIZE" value="10000000">
				<input type="submit" name="Valider">
			</form>
<?php
	if(isset($_FILES['fichier'])){
		if($etatUpload){
			echo "\t\t\t<p class='succes'> succes </p>\n";
		}
		else{
			echo "\t\t\t<p class='erreur'> échec </p>\n";
		}
	}
?>
		</div>
<?php
		}
		else{
			header('Location: index.php');
			exit();
		}
?>
    </body>
</html>
