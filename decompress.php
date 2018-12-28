<?php
	session_start();
	include("fonctions.php");
	
	if($_SESSION['autorisation']==1){
		if(isset($_GET['rep']) AND verifRepertoire($_GET['rep'])){
			$dossier = substr($_GET['rep'],0,strrpos($_GET['rep'],'/'));
			
			$p = new PharData($_GET['rep']);
			$p->decompress();
			
			$dst=$dossier.'/'.basename($_GET['rep'],'.tar.gz');
			$i=1;
			while(file_exists($dst)){
				if($i!=1){
					$dst = substr($dst,0,strrpos($dst,"("));
				}
				$dst=$dst."(".$i.")";
				$i=$i+1;
			}
			
			mkdir($dst,0777);
			
			$phar=new PharData(substr($_GET['rep'],0,strlen($_GET['rep'])-3));
			$phar->extractTo($dst);
			
			unset($p);
			unset($phar);
			
			unlink(substr($_GET['rep'],0,strlen($_GET['rep'])-3));
			
			header("Location: formUpload.php?rep=".$dossier);
			exit();
		}else{
			header("Location:formUpload.php");
			exit();
		}
	}else{
		header("Location:index.php");
		exit();
	}
?>