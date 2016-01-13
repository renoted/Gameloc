<?php 
	$userConnecte = $_SESSION['user']['firstname']." ".$_SESSION['user']['lastname'];
	$userRole = "";
	$userRole = $_SESSION['user']['role'];
	
?>
<!-- TODO utiliser les classes
				. class="active" pour indiquer la page 
				. autre classe pour faire apparaitre/disparaitre les options de menu
				. -->
<?php if ($userRole==""): ?>
<ul class="nav nav-pills">
	<li role="presentation"><a href="catalog.php">Accéder au catalogue</a></li>
	<li role="presentation"><a href="register.php">Pas encore membre ?</a></li>
</ul>
<?php endif ?>

<?php if ($userRole=="admin"): ?>	
<ul class="nav nav-pills">
	<li role="presentation"><a href="catalog.php">Accéder au catalogue</a></li>
	<li role="presentation"><a href="add_game.php">Proposer un jeu</a></li>
	<li role="presentation"><a href="profile.php">Profil</a></li>
	<li role="presentation"><a href="login.php">Se connecter</a></li>
	<li role="presentation"><a href="admin.php">Administration</a></li>
	<li role="presentation" class="pull-right"><p><a href="logout.php"> <?php echo "Déconnecter ". $userConnecte;?> </a> </li>
</ul>
<?php endif ?>

<?php if ($userRole=="member"): ?>
<ul class="nav nav-pills">
	<li role="presentation"><a href="catalog.php">Accéder au catalogue</a></li>
	<li role="presentation"><a href="add_game.php">Proposer un jeu</a></li>
	<li role="presentation"><a href="profile.php">Profil</a></li>
	<li role="presentation" class="pull-right"><p><a href="logout.php"> <?php echo "Déconnecter ". $userConnecte;?> </a> </li>
</ul>
<?php endif ?>