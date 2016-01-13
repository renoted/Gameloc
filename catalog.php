<?php

session_start();

$page = "catalog";


require(__DIR__.'/functions.php');

check_Logged_in();


if(isset($_GET['action']))  {
 	$gameName = htmlentities($_GET['search']);	// Valeur de input text
 	$platform = intval($_GET['platform']);		// tout ce qu'on récupère en GET est du string on le transforme en int
 	$available = $_GET['checkbox'];

 	// print_r($_GET);

 	// Si une plateforme est sélectionnée
 	if($platform > 0) {
 		
 		// Si la checkbox (disponible) n'est pas cochée (elle ne renvoie rien donc sa valeur est vide)
 		if(!isset($available)) {
	 		$query = $pdo->prepare('SELECT * FROM games	 
								INNER JOIN plateforms ON games.plateform_id = plateforms.id
								WHERE (games.name LIKE :search) AND (games.plateform_id = :platform)'); 
			
			$query->bindValue(':search', '%'.$gameName.'%', PDO::PARAM_STR);
			$query->bindValue(':platform', $platform, PDO::PARAM_INT);
			$query->execute();
			$results = $query->fetchAll();
		}

		// Si la checkbox (disponible) est cochée (elle renvoie une valeur de 1, donc existe bien)
		else { 
			$query = $pdo->prepare('SELECT * FROM games	 
								INNER JOIN plateforms ON games.plateform_id = plateforms.id
								WHERE (games.name LIKE :search) AND (games.plateform_id = :platform) 
								AND (games.is_available = 1)');      			// la valeur dans sql 1 correspond a true (disponible)
			$query->bindValue(':search', '%'.$gameName.'%', PDO::PARAM_STR);
			$query->bindValue(':platform', $platform, PDO::PARAM_INT);
			$query->execute();
			$results = $query->fetchAll();
		}

 	}
 	else {	// si aucune plateforme n'est sélectionnée

 		// Si la checkbox (disponible) n'est pas cochée (elle ne renvoie rien donc sa valeur est vide)
 		if(!isset($available)) {
	 		$query = $pdo->prepare('SELECT * FROM games
								INNER JOIN plateforms ON games.plateform_id = plateforms.id
								WHERE (games.name LIKE :search)');
			$query->bindValue(':search', '%'.$gameName.'%', PDO::PARAM_STR);
			$query->execute();
			$results = $query->fetchAll();
		}

		// Si la checkbox (disponible) est cochée (elle renvoie "on", donc existe bien)
		else {
			$query = $pdo->prepare('SELECT * FROM games
								INNER JOIN plateforms ON games.plateform_id = plateforms.id
								WHERE (games.name LIKE :search) AND (games.is_available = 1)');
			$query->bindValue(':search', '%'.$gameName.'%', PDO::PARAM_STR);
			$query->execute();
			$results = $query->fetchAll();
		}
 	}

 } else {
 	$query = $pdo->prepare('SELECT * FROM games'); // Prépare la requête
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
						<input type="text" class="form-control" id="search" name="search" placeholder="Search">
					</div>

					<!-- select box selected à "tous" par défaut -->			
					<label for="platform">Plateforme</label>
					<select class="form-control" id="plateform" name="platform">
						<option value="0" selected>Tous</option> 
						<option value="1" >Xbox</option>
						<option value="2" >PS4</option>
						<option value="3" >PC</option>
					</select>

					<!-- Check box -->
					<div class="checkbox">
						<label>
							<input id="checkboxCatalog" type="checkbox" name="checkbox">Disponible immédiatement
						</label>
					</div>
					<button type="submit" class="btn btn-primary" name="action">Rechercher</button>
				</form>
			</div><!-- /.divForm -->				
		</div><!-- /.col-md-3 -->

		<!-- Bloc d'affichage des jeux vidéos -->
		<div class="col-md-9">	
			<div class="container-fluid">
				<div class="row">

					<!-- Affiche la liste des jeux avec foreach -->
						<?php if(!empty($results)): ?>
							<?php foreach ($results as $keyGame => $game): ?>
								<div class="col-md-3">
									<img src="<?php echo $game['url_img']; ?>" />
									<h3><?php echo $game['name']; ?> 
										<span>
											<?php if($game['is_available'] == 1): echo ('<button type="button" class="btn btn-success btn-index"><a class="linkBtn" href="#">Louer</a></button>');?>
											<?php else: echo ('<button type="button" class="btn btn-danger disabled">Louer</button>'); ?>
											<?php endif; ?>
										</span>
									</h3>
									<p><?php echo $game['description']; ?></p>
								</div>
							<?php endforeach; ?>
						<?php else: ?>
							<h5>Désolé, aucun jeux ne correspond à votre recherche ...</h5>
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
    
</body>
</html>
