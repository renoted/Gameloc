<?php

session_start();

require(__DIR__."/functions.php");

check_logged_in();

$page = "Ajouter un jeu";

?>

<?php require(__DIR__."/include/header.php");?>

<!-- 
Date de sortie


Input date


Description


Textarea


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

		<div class="form-group">
			<label for="lname">Nom</label>
			<input type="text" class="form-control" id="lname" placeholder="lastname" name="lname" value="<?php if(isset($lname)) echo $lname ?>">
		</div>

		<div class="form-group">
			<label for="fname">Prénom</label>
			<input type="text" class="form-control" id="fname" placeholder="firstname" name="fname" value="<?php if(isset($fname)) echo $fname ?>">
		</div>

		<div class="form-group">
			<label for="address">Adresse</label>
			<input type="text" class="form-control" id="address" placeholder="address" name="address" value="<?php if(isset($address)) echo $address ?>">
		</div>

		<div class="form-group">
			<label for="zipcode">Code postale</label>
			<input type="text" class="form-control" id="zipcode" placeholder="zipcode" name="zipcode" value="<?php if(isset($zipcode)) echo $zipcode ?>">
		</div>

		<div class="form-group">
			<label for="town">Ville</label>
			<input type="text" class="form-control" id="town" placeholder="town" name="town" value="<?php if(isset($town)) echo $town ?>">
		</div>

		<div class="form-group">
			<label for="phone">Téléphone</label>
			<input type="phone" class="form-control" id="phone" placeholder="phone" name="phone" value="<?php if(isset($phone)) echo $phone ?>">
		</div>

		<button type="submit" class="btn btn-primary" name="submitBtn">Valider</button>
	</form>	
</div>

</body>
</html>