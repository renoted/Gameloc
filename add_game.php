<?php

session_start();
require(__DIR__."/functions.php");

check_logged_in();
$page = "Ajouter un jeu";
$errors = [];

if(isset($_POST["submitBtn"])){
	/*Récupération des champs dans POST*/
	$title = trim(htmlentities($_POST["title"]));
	$published = trim(htmlentities($_POST["published"]));
	$description = trim(htmlentities($_POST["description"]));
	$playingTime = trim(htmlentities($_POST["playing-time"]));
	$plateform = trim(htmlentities($_POST["plateform"]));
	
	/*Récupération de l'image*/
	$userPicture = $_FILES["user-picture"];
	
	$pictureName = $userPicture["name"];
	$pictureType = $userPicture["type"];
	$pictureTmpName = $userPicture["tmp_name"];
	$pictureSize = $userPicture["size"];
	$pictureError = $userPicture["error"];
	$pictureUrl = "public/img/$pictureName";
	/*Contrôle des données*/
	$titleErrorMessage = check_contains_characters_only($title);
	if($titleErrorMessage !== ""){
		$errors['title'] = $titleErrorMessage;
	}

	/*Contrôle de l'image*/
	if($userPicture) {
		if(!strstr($pictureType, 'jpg') && !strstr($pictureType, 'jpeg') && !strstr($pictureType, 'png')) {
			$errors["picture"] = "L'image choisie n'est pas dans le bon format.";
		} else if ($pictureSize > 10000000) {
			$errors['picture'] = "Le fichier dépasse le poids max";
		} elseif(!move_uploaded_file($pictureTmpName, __DIR__.'/public/img/'.$pictureName)) {
			$errors['picture'] = "Votre image n'a pas été uploadé correctement";
		}		
	} else {
		$errors["picture"] = "Vous devez insérer une image.";
	}

	/*Ajout du jeu dans la bdd*/
	$query = $pdo->prepare("INSERT INTO `games`(`name`, `url_img`, `description`, `published_at`, `game_time`, `plateform_id`)
							VALUES (:title, :imageUrl, :description, :published, :playingTime, :plateform);");
	$query->bindValue(":title", $title, PDO::PARAM_STR);
	$query->bindValue(":imageUrl", $pictureUrl, PDO::PARAM_STR);
	$query->bindValue(":description", $description, PDO::PARAM_STR);
	$query->bindValue(":published", $published, PDO::PARAM_STR);
	$query->bindValue(":playingTime", $playingTime, PDO::PARAM_STR);
	$query->bindValue(":plateform", $plateform, PDO::PARAM_INT);
	$query->execute();

	/*Message de succès*/
	/*Vidage des champs*/
}

?>

<?php require(__DIR__."/include/header.php");?>

<div class="container">
	<form method="post" action=<?php echo $_SERVER["PHP_SELF"] ?> enctype="multipart/form-data">
		<div class="form-group">
			<label for="title">Titre *</label>
			<input type="text" class="form-control" id="title" placeholder="Titre" name="title" value="<?php if(isset($title)) echo $title ?>">
		</div>
		<?php print_error_message($errors, "title"); ?>
		
		<div class="form-group">
			<label for="user-picture">Image du jeux (jpg/jpeg ou png) *</label>
			<input type="file" id="user-picture" name="user-picture">
		</div>
		<?php print_error_message($errors, "picture"); ?>

		<div class="form-group">
			<label for="published">Date de sortie</label>
			<input type="text" class="form-control" id="published" placeholder="Date de sortie" name="published" value="<?php if(isset($published)) echo $published ?>">
		</div>
		<div class="form-group">
			<label for="published">Description</label>
			<textarea id="description" class="form-control" placeholder="Description" name="description" rows="3"><?php if(isset($description)) echo $description ?></textarea>
		</div>
		<div class="form-group">
			<label for="playing-time">Temps de jeu</label>
			<input type="text" class="form-control" id="playing-time" placeholder="Temps de jeu" name="playing-time" value="<?php if(isset($playingTime)) echo $playingTime ?>">
		</div>
		<div class="form-group">
			<label for="plateform">Plateforme</label>
			<select id="plateform" name="plateform" class="form-control">
				<option value="1" <?php if(isset($plateform)){if($plateform === "1"){echo "selected";}}?>>Xbox</option>
				<option value="2" <?php if(isset($plateform)){if($plateform === "2"){echo "selected";}}?>>PS4</option>
				<option value="3" <?php if(isset($plateform)){if($plateform === "3"){echo "selected";}}?>>PC</option>
			</select>
			
		</div>
		<button type="submit" class="btn btn-primary" name="submitBtn">Valider</button>
	</form>	
</div>

</body>
</html>