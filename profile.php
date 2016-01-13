<?php
	session_start();
	require(__DIR__.'/functions.php');

	// checkLoggedIn();

	$page = "Bienvenue";
	// TODO pour récupérer le prénom de l'utilisateur
	$userConnecte = $_SESSION['user']['firstname'];
	
	/*
	// Je check que l'utilisateur est bien loggué sinon je redirige vers index.php
	if(empty($_SESSION['user'])) {
		// On redirige dans l'index
		header("Location: index.php");
		// Force l'arrêt de cette page
		die();
	}*/
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Bienvenue</title>
		<meta charset='utf-8'>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	</head>
	<body>

		<?php include('/include/header.php'); ?>

		<div class="container">
					<!-- TODO passer le nom de l'user pour la bienvenue -->
					<p>Bienvenue  <?php echo $userConnecte; ?>   </p>
					<p>Cette page est accessible que pour les nouveaux utilisateurs ou 
					les utilisateurs connectés</p>
		</div>
	</body>
</html>

