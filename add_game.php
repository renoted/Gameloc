<?php

session_start();

require(__DIR__."/functions.php");

check_logged_in();

$page = "Ajouter un jeu";

if(isset($_POST["submitBtn"])){
	$title = $_POST["title"];
	$userPicture = $_FILES["user-picture"];
	$published = $_POST["published"];
	$description = $_POST["description"];
	$playingTime = $_POST["playing-time"];
	$plateform = $_POST["plateform"];
	print_r($_POST);
	print_r($_FILES);
}

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
	<form method="post" action=<?php echo $_SERVER["PHP_SELF"] ?> enctype="multipart/form-data">
		<div class="form-group">
			<label for="title">Titre *</label>
			<input type="text" class="form-control" id="title" placeholder="titre" name="title" value="<?php if(isset($title)) echo $title ?>">
		</div>
		
		<div class="form-group">
			<label for="user-picture">Image du jeux *</label>
			<input type="file" id="user-picture" name="user-picture">
		</div>

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
			<input type="text" class="form-control" id="playing-time" placeholder="Date de sortie" name="playing-time" value="<?php if(isset($playingTime)) echo $playingTime ?>">
		</div>
		<div class="form-group">
			<label for="plateform">Plateforme</label>
			<select id="plateform" name="plateform" class="form-control">
				<option value="0" <?php if(isset($plateform)){if($plateform === "0"){echo "selected";}}else{echo "selected";} ?>>Tous</option>
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