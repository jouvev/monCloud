<?php
	session_start();
	include("fonctions.php");
	
	$extensionImage=array('jpg', 'jpeg', 'png', 'bmp', 'gif');
	$extentionApplication=array('pdf');
		
	if($_SESSION['autorisation']==1){
		$txt="";
		if(isset($_GET['rep']) AND verifRepertoire($_GET['rep']) AND is_dir($_GET['rep'])==FALSE){
			$extension = substr(strrchr($_GET['rep'], '.'), 1);
			
			if(in_array($extension, $extentionApplication)){
				header('Content-Type: application/'.$extension);
				readfile($_GET['rep']);
				exit();
			}
			elseif(in_array($extension, $extensionImage)){
				header('Content-Type: image/'.$extension);
				readfile($_GET['rep']);
				exit();
			}
			else{
?>
<html>
	<head>
		<title>lecture</title>
		<meta charset="utf-8" />
		<style>
			*{
				margin:0px;
				margin-left:5px;
				padding:1px;
			}
		</style>
	</head>

	<body>
<?php
						$fichier=fopen($_GET['rep'],'r');
						while(($ligne=fgets($fichier))!==FALSE){
							$txt=$txt.$ligne;
						}
						echo "\t\t<pre>".str_replace('<','&lt;',$txt)."\t\t</pre>";
?>	
	</body>
</html>
<?php
			}
		}else{
			header("Location:formUpload.php");
			exit();
		}
	}
?>

