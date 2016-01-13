<?php

session_start();

require(__DIR__."/functions.php");

check_logged_in();

$page = "Ajouter un jeu";

?>

<?php require(__DIR__."/include/header.php");?>

<!-- 
Temps de jeux


Input text 
Chiffre
Plateforme


Selectbox
 -->

<div class="container">
	<form method="post" action=<?php echo $_SERVER["PHP_SELF"] ?> enctype="multipart/form-data" >
		<div class="form-group">
			<label for="title">Titre</label>
			<input type="text" class="form-control" id="title" placeholder="titre" name="titre">
		</div>
		
		<div class="form-group">
			<input type="file" name="user-picture">
		</div>

		<div class="form-group">
			<label for="published">Date de sortie</label>
			<input type="text" class="form-control" id="published" placeholder="Date de sortie" name="published" value="<?php if(isset($published)) echo $published ?>">
		</div>

		<div>
			<label for="published">Description</label>
			<textarea id="description" placeholder="Description" name="description" value="<?php if(isset($description)) echo $published ?>"></textarea>
		</div>

		<button type="submit" class="btn btn-primary" name="submitBtn">Valider</button>
	</form>	
</div>

</body>
</html>