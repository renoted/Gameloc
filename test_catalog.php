<?php

session_start();
require(__DIR__.'/functions.php');

$page = "Catalogue";

/*Calcul du nombre d'éléments à afficher*/

//Nombre de résultats par page
const NB_RESULTS_PER_PAGE = 4;

//Calcul du nombre total de jeux dans la bdd
$query = $pdo->prepare("SELECT count(id) as total FROM games;");
$query->execute();
$results = $query->fetch();
$total = $results["total"];

//Calcul du nombre de pages
$nbPages = $total/NB_RESULTS_PER_PAGE;

if(isset($_GET['action']))  {
 	/*Récupération des données saisies par l'utilisateur*/
 	$gameName = trim(htmlentities($_GET['search']));
 	$platform = intval(trim(htmlentities($_GET['platform'])));
 	if(isset($_GET['checkbox'])){//si la checkbox est cliquée, $available = 1, sinon 0
 		$available = 1;		
 	} else {
 		$available = 0;
 	}

 	/*On va générer la requête SQL en fonction de la recherche de l'utilisateur*/
 	//Préparation de la requête SQL
 	$SQLRequest = "SELECT * FROM games WHERE ";
 	$SQLRequestConditions = [];
 	if(!empty($gameName)){
 		array_push($SQLRequestConditions, "NAME LIKE :gameName");
 	}
 	if($platform !== 0){
 		array_push($SQLRequestConditions, "plateform_id = :platform");
 	}
 	if($available === 1){
 		array_push($SQLRequestConditions, "is_available = :available");
 	}

 	//Si le tableau de requête est vide, c'est qu'aucune recherche n'a été effectuée, on retourne donc un message d'erreur,
 	//Sinon, on créer la requête.
 	if(count($SQLRequestConditions) === 0){
 		$errors["search"] = "Vous n'avez effectué aucune recherche";
 	} else if(count($SQLRequestConditions) > 1) {
 		for($i=0; $i < count($SQLRequestConditions)-1; $i++){
 			$SQLRequest .= $SQLRequestConditions[$i]." AND " ;
 		}
 		$SQLRequest .= $SQLRequestConditions[count($SQLRequestConditions)-1];

 	} else if(count($SQLRequestConditions) === 1){
 		$SQLRequest .= $SQLRequestConditions[0];
 	}
 
 	/*On effectue la recherche avec la requête que nous avons générée*/
	if(!isset($errors["search"])) {
		$query = $pdo->prepare($SQLRequest);
		if(!empty($gameName)){
	 		$query->bindValue(":gameName", "%$gameName%", PDO::PARAM_STR);
	 	}
	 	if($platform !== 0){
	 		$query->bindValue(":platform", $platform, PDO::PARAM_INT);
	 	}
	 	if($available === 1){
	 		$query->bindValue(":available", $available, PDO::PARAM_INT);
	 	}
		$query->execute();
		$results = $query->fetchAll();
	}

 	
 } else {
 	$query = $pdo->prepare("SELECT * FROM games;");
	$query->execute();
	$results = $query->fetchAll();
 }
 
/*TODO
	Afficher 4 éléments par page
*/


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
		
					Affiche la liste des jeux avec foreach
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
							<h5>Désolé, aucun jeu ne correspond à votre recherche ...</h5>
						<?php endif; ?>
				</div>
			</div>
			<!-- Pagination -->
			<div>
				<ul class="pagination">
				    <li>
				      <a href="#" aria-label="Previous">
				        <span aria-hidden="true">&laquo;</span>
				      </a>
				    </li>
					<?php for($page=1; $page<=$nbPages; $page++): ?>
				    <li><a href="<?php echo $_SERVER["PHP_SELF"]."?page=$page" ?>" ><?php echo $page ?></a></li>
					<?php endfor; ?>
				    <li>
				      <a href="#" aria-label="Next">
				        <span aria-hidden="true">&raquo;</span>
				      </a>
				    </li>
				 </ul>
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
