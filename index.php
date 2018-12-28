<?php
	session_start();
	if(isset($_SESSION['autorisation']) AND $_SESSION['autorisation']==1){
		header('Location:formUpload.php');
		exit();
	}
?>

<!DOCTYPE html>

<html>
	<head>
		<title> authentification </title>
		<meta charset="utf-8" />
		<link rel="stylesheet" href="css/styleIndex.css">
	</head>

	<body>
		<div id="block">
		<form method="post" action= "index.php">
			<h1> Authentification: </h1>
			<label for = "mdp" >MDP : </label>
			<input type="password" name="mdp" autofocus/>
			<input type="submit" value="Valider"/>

		</form>
<?php
		if(isset($_GET['erreur']) AND $_GET['erreur']=="1"){
			echo "<p class='erreur'>Mauvais mot de passe !</p>";
		}
		if(isset($_POST['mdp']) AND $_POST['mdp']=="302f25631"){
			$_SESSION['autorisation']=1;
			header('Location: formUpload.php');
			exit();
		}if(isset($_POST['mdp']) AND $_POST['mdp']!="302f25631"){
			header('Location: index.php?erreur=1');
			exit();
		}
?>
		</div>

	</body>
</html>
