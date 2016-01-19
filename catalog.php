<?php

session_start();

$page = "catalogue";


require(__DIR__.'/functions.php');

// On peut accéder au catalogue même sans être identifié
// check_Logged_in();

// Lorsqu'on charge la page catalog.php, c'est à dire qu'il n'y a pas de page envoyé en get dans l'url
// ou que le bouton n'a pas été submit
// On s'assure d'éliminer les variables de SESSION suivantes :
if(!isset($_GET['page']) || isset($_GET['action'])) {
	unset($_SESSION['gameName']);
	unset($_SESSION['available']);
	unset($_SESSION['platform']);
	unset($_SESSION['pageVideoGames']);
	

}

$query = $pdo->query('SELECT * FROM plateforms');
$allPlatforms = $query->fetchAll();


// PAGINATION : calculer le nombre de page lors de l'affichage de toute la bdd

// Grâce à une query et la fonction SQL COUNT, récupérer le nombre total de video games dans ma bdd
// La variable $totalGames sera utilisée pour l'affichage par défaut de tous les jeux vidéo (lors du chargement de la page catalog.php par exemple) 
$query = $pdo->query('SELECT COUNT(*) AS total FROM games');
$countGames = $query->fetch();
$totalGames = $countGames['total'];

$limitVideoGames = 4;	// nombre de jeux affichés par page

	
// Diviser le nombre de jeux vidéos retourné par la limite par page et arrondir à l'entier supérieur
// on obtient le nombre de pages
$_SESSION['pageVideoGames'] = ceil ($totalGames / $limitVideoGames);


// Récupérer la variable page envoyée en GET et l'affecter à $pageActiveVideoGames
if(isset($_GET['page'])) {
 	$pageActiveVideoGames = $_GET['page'];
 }
 else {
 	$pageActiveVideoGames=1;
}

// Créer la variable $totaloffsetVideoGames et la binder dans la requete SQL pour l'affichage par défaut (bouton n'est pas submit)
$totalOffsetVideoGames = ($pageActiveVideoGames-1) * $limitVideoGames;


// BOUTON SUBMIT de la recherche de jeux vidéod

// 1er bloc d'instructions qui va faire les requètes pour obtenir les résultats


if(isset($_GET['action']))  {

	// echo ("<br>.".$_SESSION['available']."<br>");
	// echo ("je rentre ds la 1ere condition if : "."<br>");
	// echo ($_GET['checkbox']);
 	$_SESSION['gameName'] = htmlentities($_GET['search']);	// Valeur de input text
 	$_SESSION['platform'] = intval($_GET['platform']);		// tout ce qu'on récupère en GET est du string on le transforme en int
 	$_SESSION['available'] = isset($_GET['checkbox']);	// Si la checkbox (disponible) n'est pas cochée (elle ne renvoie rien donc sa valeur est vide)

 	// if(isset($_SESSION['available'])) {
 	// 	echo ("avalaible est défini ds la 1ere conditions if"."<br>");
 	// }
 	// // print_r($_GET);

 	// Si une plateforme est sélectionnée
 	if($_SESSION['platform'] > 0) {
 		
 		// Si la checkbox (film disponible) n'est pas cochée
 		if(!$_SESSION['available']) {
	 		$query = $pdo->prepare('SELECT * FROM games
								INNER JOIN plateforms ON games.plateform_id = plateforms.id
								WHERE (games.name LIKE :search) AND (games.plateform_id = :platform)'); 
			$query->bindValue(':search', '%'.$_SESSION['gameName'].'%', PDO::PARAM_STR);
			$query->bindValue(':platform', $_SESSION['platform'], PDO::PARAM_INT);
			$query->execute();
			$_SESSION['results'] = $query->fetchAll();
		}

		// Si la checkbox (film disponible) est cochée 
		else { 
			$query = $pdo->prepare('SELECT * FROM games
								INNER JOIN plateforms ON games.plateform_id = plateforms.id
								WHERE (games.name LIKE :search) AND (games.plateform_id = :platform) 
								AND (games.is_available = 1)');      			// la valeur dans sql 1 correspond a true (disponible)
			$query->bindValue(':search', '%'.$_SESSION['gameName'].'%', PDO::PARAM_STR);
			$query->bindValue(':platform', $_SESSION['platform'], PDO::PARAM_INT);
			$query->execute();
			$_SESSION['results'] = $query->fetchAll();
		}

 	}
 	else {	// si aucune plateforme n'est sélectionnée

 		// Si la checkbox (disponible) n'est pas cochée
 		if(!$_SESSION['available']) {
	 		$query = $pdo->prepare('SELECT * FROM games
								INNER JOIN plateforms ON games.plateform_id = plateforms.id
								WHERE (games.name LIKE :search)');
			$query->bindValue(':search', '%'.$_SESSION['gameName'].'%', PDO::PARAM_STR);
			$query->execute();
			$_SESSION['results'] = $query->fetchAll();
		}

		// Si la checkbox (disponible) est cochée 
		else {
			$query = $pdo->prepare('SELECT * FROM games
								INNER JOIN plateforms ON games.plateform_id = plateforms.id
								WHERE (games.name LIKE :search) AND (games.is_available = 1)');
			$query->bindValue(':search', '%'.$_SESSION['gameName'].'%', PDO::PARAM_STR);
			$query->execute();
			$_SESSION['results'] = $query->fetchAll();
		}
 	}

 } 


// 2ème bloc d'instructions pour effectuer les requètes SQL en bindant la variable $offsetVideoGames 


// Si le bouton submit a été cliqué ou si l'input search, le select ou la checkbox ont été rempli dans la recherche précédente
if( isset($_SESSION['gameName']) || isset($_SESSION['platform']) || isset($_SESSION['available']) )  {
 	
 	
	// PAGINATION lorsque les resultats de la recherche ont été renvoyé on recalcul le nombre de pages pour redefinir 
	// la variable $offsetVideoGames qui sera bindé dans la 2ème série de requètes SQL

	// 1. compter le nombre de jeux vidéos retourner dans la recherche précédente
	$totalVideoGames = count($_SESSION['results']);

	// 3. Diviser le nombre de jeux vidéos retourné   par la limite par page et arrondir à l'entier supérieur
	// on obtient le nombre de pages
	$_SESSION['pageVideoGames'] = ceil ($totalVideoGames / $limitVideoGames);
	

	// Récupérer la variable page envoyée en GET et l'affecter à $pageActiveVideoGames
	if(isset($_GET['page'])) {
	 	$pageActiveVideoGames = $_GET['page'];
	 }
	 else {
	 	$pageActiveVideoGames=1;
	}

	// Créer la variable $offsetVideoGames et la binder dans la requete SQL
	$offsetVideoGames = ($pageActiveVideoGames-1) * $limitVideoGames;

	

 	
 	// Si une plateforme est sélectionnée
 	if($_SESSION['platform'] > 0) {
 		
 		// Si la checkbox (disponible) n'est pas cochée (elle ne renvoie rien donc sa valeur est vide)
 		if(!$_SESSION['available']) {
	 		$query = $pdo->prepare('SELECT games.id, games.name, games.url_img, games.description, games.published_at
	 							 , games.game_time, games.is_available, games.created_at, games.updated_at, games.plateform_id 
	 							FROM games	
								INNER JOIN plateforms ON games.plateform_id = plateforms.id
								WHERE (games.name LIKE :search) AND (games.plateform_id = :platform)
								LIMIT :limit OFFSET :offset'); 
			$query->bindValue(':limit', $limitVideoGames, PDO::PARAM_INT);
			$query->bindValue(':offset', $offsetVideoGames, PDO::PARAM_INT);
			$query->bindValue(':search', '%'.$_SESSION['gameName'].'%', PDO::PARAM_STR);
			$query->bindValue(':platform', $_SESSION['platform'], PDO::PARAM_INT);
			$query->execute();
			$results = $query->fetchAll();
		}

		// Si la checkbox (disponible) est cochée (elle renvoie une valeur de 1, donc existe bien)
		else { 
			$query = $pdo->prepare('SELECT games.id, games.name, games.url_img, games.description, games.published_at
	 							 , games.game_time, games.is_available, games.created_at, games.updated_at, games.plateform_id
	 							FROM games	
								INNER JOIN plateforms ON games.plateform_id = plateforms.id
								WHERE (games.name LIKE :search) AND (games.plateform_id = :platform) 
								AND (games.is_available = 1)
								LIMIT :limit OFFSET :offset');      			// la valeur dans sql 1 correspond a true (disponible)
			$query->bindValue(':limit', $limitVideoGames, PDO::PARAM_INT);
			$query->bindValue(':offset', $offsetVideoGames, PDO::PARAM_INT);
			$query->bindValue(':search', '%'.$_SESSION['gameName'].'%', PDO::PARAM_STR);
			$query->bindValue(':platform', $_SESSION['platform'], PDO::PARAM_INT);
			$query->execute();
			$results = $query->fetchAll();
		}

 	}
 	else {	// si aucune plateforme n'est sélectionnée

 		// Si la checkbox (disponible) n'est pas cochée (elle ne renvoie rien donc sa valeur est vide)
 		if(!$_SESSION['available']) {
	 		$query = $pdo->prepare('SELECT games.id, games.name, games.url_img, games.description, games.published_at
	 							 , games.game_time, games.is_available, games.created_at, games.updated_at, games.plateform_id
	 							FROM games 
								INNER JOIN plateforms ON games.plateform_id = plateforms.id
								WHERE (games.name LIKE :search)
								LIMIT :limit OFFSET :offset');
	 		$query->bindValue(':limit', $limitVideoGames, PDO::PARAM_INT);
			$query->bindValue(':offset', $offsetVideoGames, PDO::PARAM_INT);
			$query->bindValue(':search', '%'.$_SESSION['gameName'].'%', PDO::PARAM_STR);
			$query->execute();
			$results = $query->fetchAll();
		}

		// Si la checkbox (disponible) est cochée (elle renvoie "on", donc existe bien)
		else {
			$query = $pdo->prepare('SELECT games.id, games.name, games.url_img, games.description, games.published_at
	 							 , games.game_time, games.is_available, games.created_at, games.updated_at, games.plateform_id
	 							FROM games
								INNER JOIN plateforms ON games.plateform_id = plateforms.id
								WHERE (games.name LIKE :search) AND (games.is_available = 1)
								LIMIT :limit OFFSET :offset');
			$query->bindValue(':limit', $limitVideoGames, PDO::PARAM_INT);
			$query->bindValue(':offset', $offsetVideoGames, PDO::PARAM_INT);
			$query->bindValue(':search', '%'.$_SESSION['gameName'].'%', PDO::PARAM_STR);
			$query->execute();
			$results = $query->fetchAll();
		}
 	}

 } 

 if(!isset($_GET['action']) && !isset($_SESSION['gameName']) && !isset($_SESSION['platform']) && !isset($_SESSION['available'])) {
	
	
	$query = $pdo->prepare('SELECT * FROM games LIMIT :limit OFFSET :offset'); // Prépare la requête
 	$query->bindValue(':limit', $limitVideoGames, PDO::PARAM_INT);
	$query->bindValue(':offset', $totalOffsetVideoGames, PDO::PARAM_INT);
	$query->execute();
	$results = $query->fetchAll();
 }

?>

<!-- On inclut le header ( <head> + début du <body> + jumbotron + logo) -->
<?php include(__DIR__.'/include/header.php'); ?>

<div class="container-fluid">
	<div class="row">

		<!-- bloc qui contient le formulaire -->
		<div class="col-md-3">
			<div id="divFormCatalog">			  	
				<!-- Formulaire -->
				<form id="form" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
					<div class="form-group">
						<label for="search">Rechercher</label>
						<!-- Remplir automatiquement la value de l'input search si une recherche précédente a été faite  -->
						<input type="text" class="form-control" id="search" name="search" placeholder="Search" 
								value="<?php if (isset($_SESSION['gameName'])) echo $_SESSION['gameName']; ?>">
					</div>

					<!-- select box selected à "tous" par défaut -->			
					<label for="platform">Plateforme</label>
					<select class="form-control" id="plateform" name="platform">
							<option value="0">Tous</option> 
								<!-- Faire foreach pour générer les options -->
	  							<!-- Préselectionner la bonne option platform de la recherche précédente -->
								<?php foreach ($allPlatforms as $keyPlatform => $Platform): ?>  									
									<option value="<?php echo $Platform['id']; ?>"
										<?php if(isset($_SESSION['platform'])): ?>
											<?php if($_SESSION['platform'] == $Platform['id']): echo "selected"; endif; ?>
										<?php endif;?> >
											<?php echo $Platform['name']; ?>										
									</option>
								<?php endforeach; ?>
					</select>
					<!-- Check box -->
					<div class="checkbox">
						<label>
							<!-- Condition if relative à l'attribut checked de la checkbox -->
							<!-- if : Préselectionner l'attribut checked si celui-ci a été enregistré lors du submit -->
							<!--  else if : afficher checked si la $_SESSION['available'] existe cad que la selected box -->
							<!-- a été checkée lors d'un submit précédent -->
							<input id="checkboxCatalog" type="checkbox" name="checkbox" 
								<?php if(isset($_GET['checkbox'])): ?>
									<?php echo "checked"; ?>									 
								<?php elseif(isset($_SESSION['available'])): ?>
									<?php if($_SESSION['available']): ?>
										<?php echo "checked"; ?> 										
									<?php endif; ?>								
								<?php endif; ?> >Disponible immédiatement
						</label>
					</div>
					<button type="submit" class="btn btn-primary" name="action">Rechercher</button>
				</form>
			</div><!-- /.divForm -->				
		</div><!-- /.col-md-3 -->

		<!-- Bloc d'affichage des jeux vidéos -->
		<div class="col-md-9">	
				<nav>
					<ul class="pagination">
						<!-- Page précédente -->
						<?php if($pageActiveVideoGames > 1): ?>
						    <li class="">
						    	<a href="catalog.php?page=<?php echo $pageActiveVideoGames - 1; ?>" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
						<?php else: ?>
							<li class="disabled">
								<a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>
						<?php endif; ?>

					    <!-- Affichage dynamique du nbre de page -->
					    <?php if (isset($_SESSION['pageVideoGames'])) : ?>
					    	<?php for ($i=1; $i <= $_SESSION['pageVideoGames']; $i++): ?>
							    <li class="
							    	<?php if($pageActiveVideoGames == $i): echo "active"; endif; ?>">
							    	<a href="catalog.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
							    </li>
							<?php endfor; ?>  
					    <?php endif; ?>

					    <!-- Page suivante -->
					    <?php if (isset($_SESSION['pageVideoGames'])) : ?>
						    <?php if($pageActiveVideoGames < $_SESSION['pageVideoGames']): ?>
							    <li class="">
							    	<a href="catalog.php?page=<?php echo $pageActiveVideoGames + 1; ?>" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
							<?php else: ?>
								<li class="disabled">
									<a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>
							<?php endif; ?>
						<?php endif; ?>
					</ul>
				</nav>


			<div class="row">

					<!-- Affiche la liste des jeux avec foreach -->
						<?php if(!empty($results) ): ?>
							<?php foreach ($results as $keyGame => $game): ?>
								<div class="col-sm-3">
									<div class="container containerImg">
										<img class="imgGame" src="<?php echo $game['url_img']; ?>" />
										<h3><?php echo "<b>".$game['name']."</b><br>"; ?> 
											<span>
												<?php if($game['is_available'] == 1): echo ('<button type="button" class="btn btn-success btn-index"><a class="linkBtn" href="#">Louer</a></button>');?>
												<?php else: echo ('<button type="button" class="btn btn-danger disabled">Louer</button>'); ?>
												<?php endif; ?>
											</span>
										</h3>
										<p><?php echo "<b>"."Description : "."</b><br>".$game['description']; ?></p>
										<p><?php echo "<b>"."Date de sortie : "."</b>".$game['published_at']; ?></p>
										<p><?php echo "<b>"."Temps pour terminer le jeu : "."</b>".$game['game_time']; ?></p>
									</div>
								</div>
							<?php endforeach; ?>
						
						<?php elseif(!isset($_SESSION['results'])):?>
							<?php foreach ($_SESSION['results'] as $keyGame => $game): ?>
								<div class="col-sm-3">
									<div class="container containerImg">
										<img class="imgGame" src="<?php echo $game['url_img']; ?>" />
										<h3><?php echo "<br><b>".$game['name']."</b><br>"; ?> 
											<span>
												<?php if($game['is_available'] == 1): echo ('<button type="button" class="btn btn-success btn-index"><a class="linkBtn" href="#">Louer</a></button>');?>
												<?php else: echo ('<button type="button" class="btn btn-danger disabled">Louer</button>'); ?>
												<?php endif; ?>
											</span>
										</h3>
										<p><?php echo "<b>"."Description : "."</b><br>".$game['description']."<br>"; ?></p>
										<p><?php echo "<b>"."Date de sortie : "."</b>".$game['published_at']."<br>"; ?></p>
										<p><?php echo "<b>"."Temps pour terminer le jeu : "."</b>".$game['game_time']."<br>"; ?></p>
									</div>
								</div>
							<?php endforeach; ?>
						
						<?php else: ?>
							<h5>Désolé, aucun jeu ne correspond à votre recherche ...</h5>
						<?php endif; ?>
				</div>
			</div>
		</div>

	</div>
</div>





    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    
<?php require(__DIR__."/include/footer.php");?>
