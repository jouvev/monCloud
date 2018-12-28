<?php
	session_start();
	include("fonctions.php");
	
	if($_SESSION['autorisation']==1){
		if(isset($_GET['rep']) AND verifRepertoire($_GET['rep'])){
			if(is_dir($_GET['rep'])==FALSE){
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header("Content-Disposition: attachment; filename=\"" . basename($_GET['rep'])."\"");
				header('Content-Transfer-Encoding: binary');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
				header('Content-Length: ' . filesize($_GET['rep']));
				readfile($_GET['rep']);
				
			}else{
				$phar = new PharData("tmp/".basename($_GET['rep']).".tar");
				
				archive($_GET['rep'],"",$phar);
				
				$phar->compress(Phar::GZ);
				
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header("Content-Disposition: attachment; filename=\"" .basename($_GET['rep']).".tar.gz"."\"");
				header('Content-Transfer-Encoding: binary');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
				header('Content-Length: ' . filesize("tmp/".basename($_GET['rep']).".tar.gz"));
				readfile("tmp/".basename($_GET['rep'].".tar.gz"));
				
				unset($phar);
				
				Phar::unlinkArchive("tmp/".basename($_GET['rep']).".tar");
				unlink("tmp/".basename($_GET['rep']).".tar.gz");
			}
			exit();
		}else{
			header("Location:formUpload.php");
			exit();
		}
	}
	header("Location:index.php");
	exit();
?>
