<?php
function upload($rep){
	if(isset($_FILES['fichier'])){
		if($_FILES['fichier']['error']==0){
			if(strrpos($_FILES['fichier']['name'],'.')!=FALSE){
				$extension=trim(substr($_FILES['fichier']['name'],strrpos($_FILES['fichier']['name'],'.')));
				$name=trim(substr($_FILES['fichier']['name'],0,strrpos($_FILES['fichier']['name'],'.')));
			}else{
				$name=$_FILES['fichier']['name'];
				$extension="";
			}
			$i=1;
			while(file_exists($rep."/".$name.$extension)){
				if($i!=1){
					$name = substr($name,0,strrpos($name,"("));
				}
				$name=$name."(".$i.")";
				$i=$i+1;
			}
			return move_uploaded_file($_FILES['fichier']['tmp_name'],$rep."/".$name.$extension);
		}
		else{
			return FALSE;
		}
	}
}

function convertionTaille($taille){ // convertion du poid du fichier en B, KB ou MB
	$tab=array('B','KB','MB');
	$i=1;
	while(floor($taille / pow(1024,$i)) > 0 AND $i < 4){
		$i=$i+1;
	}
	return (floor($taille / pow(1024,$i-1)))." ".$tab[$i-1];
}

function verifRepertoire($rep){
	return (file_exists($rep) AND  //verifie que le fichier existe 
			substr_compare($rep,'ftp',0,3)==0 AND //verifie que la racine est bien le dossier ftp
			strpos($rep,'..')===FALSE); //on verifie qu'on ne retourne pas dans un dossier precedent
}

function delTree($dir) { // supprime recursivement un dossier (pris sur le site php.net)
	$files = array_diff(scandir($dir), array('.','..'));
	foreach ($files as $file) {
		(is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
	}
	return rmdir($dir);
}

function archive($rep, $repCourant, $p){ // archive un dossier pour le download par la suite

/*$rep c'est chemin ver le dossier a archiver
	$repCourant est le dossier dans le qu'elle on se trouve dans l'archive
	$p est le pointeur vers l'objet PharData */
	
	if(empty($repCourant)){
		$repCourant=basename($rep);
	}else{
		$repCourant="$repCourant/".basename($rep);
	}
	$p->addEmptyDir($repCourant);
	$repfils = array_diff(scandir($rep), array('.','..'));
	foreach($repfils as $elem){
		if(is_dir("$rep/$elem")){
			archive("$rep/$elem",$repCourant,$p);
		}else{
			if(empty($repCourant)){
				$p->addFile("$rep/$elem","$elem");
			}else{
				$p->addFile("$rep/$elem","$repCourant/$elem");
			}
		}
	}
}

function copie($source, $destination){
	if(!file_exists($destination."/".basename($source))){
		if(is_dir($source)){
			mkdir($destination."/".basename($source),0777);
			$files = array_diff(scandir($source), array('.','..'));
			foreach($files as $elem){
				if(is_dir($source."/".$elem)){
					copie($source."/".$elem,$destination."/".basename($source));
				}else{
					copy($source."/".$elem,$destination."/".basename($source)."/".$elem);//manque exception
				}
			}
		}else{
			 copy($source,$destination."/".basename($source));//manque exception
		}
		return True;
	}
	else{
		return FALSE;
	}
}

function deplacer($source, $destination){
	if(copie($source,$destination)){
		if(is_dir($source)){
			delTree($source);//manque exception
		}else{
			unlink($source);//manque exception
		}
		return True;
	}
	else{
		return FALSE;
	}
}

function cheminIcon($extension){
	switch($extension){
		case ".pdf":
			return "image/pdf.png";
			break;
		
		case ".png":
		case ".jpg":
		case ".jpeg":
		case ".bmp":
			return "image/image.png";
			break;
		
		case ".zip":
		case ".gz":
		case ".rar":
			return "image/archive.png";
			break;
			
		case ".txt":
			return "image/txt.png";
			break;
		
		default:
			return "image/file.png";
	}
}

?>
