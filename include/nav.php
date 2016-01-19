<ul class="nav nav-pills">

<?php
	// pas d'utilisateur identifié - affichage menu réduit
	if(!isset($_SESSION['user'])) {
		$userRole = "";
		$userConnecte = "";
		?>
		<li role="accès catalogue"><a href="catalog.php">Accéder au catalogue</a></li>
		<li role="s'enregistrer"><a href="register.php">Pas encore membre ?</a></li>
		<?php
	}
	else {
		// utilisateur identifié - affichage menu complet
		?>	
			<li role="accès catalogue"><a href="catalog.php">Accéder au catalogue</a></li>
			<li role="ajout jeu"><a href="add_game.php">Proposer un jeu</a></li>
			<li role="modifier le profil"><a href="profile.php">Profil</a></li>
		<?php
		$userConnecte = $_SESSION['user']['firstname']." ".$_SESSION['user']['lastname'];
		$userRole = $_SESSION['user']['role'];
		
		if ($userRole=="admin"); {
			// utilisateur identifié comme admin - affichage menu complémentaire
			?>
			<li role="se connecter"><a href="login.php">Se connecter</a></li>
			<li role="administrer"><a href="admin.php">Administrer</a></li>
			<?php
		}
		?>
		<li role="se déconnecter" class="pull-right"><p><a href="logout.php"> <?php echo "Déconnecter ". $userConnecte;?> </a> </li>
		<?php
	}
?>


<!-- TODO utiliser les classes
				. class="active" pour indiquer la page 
				. autre classe pour faire apparaitre/disparaitre les options de menu
				. -->