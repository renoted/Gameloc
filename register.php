<?php

	session_start();

	require(__DIR__."/config/db.php");

	/*Récupération des données du formulaire*/
	if(isset($_POST["submitBtn"])){
		$email = trim(htmlentities($_POST["email"]));
		$password = trim(htmlentities($_POST["password"]));
		$confirmPassword = trim(htmlentities($_POST["confirmPassword"]));
		$lname = trim(htmlentities($_POST["lname"]));
		$fname = trim(htmlentities($_POST["fname"]));
		$address = trim(htmlentities($_POST["address"]));
		$zipcode = trim(htmlentities($_POST["zipcode"]));
		$town = trim(htmlentities($_POST["town"]));
		$phone = trim(htmlentities($_POST["phone"]));

		/*Instanciation du tableau d'erreurs*/
		$errors = [];

		/*Contrôle de la validité des données*/

		/*1. Contrôle du champ "Email" */

		if(!isset($email)){
			$errors["email"] = "Le champ \"Email\" doit être rempli."; 
		} else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$errors["email"] = "Le format de l'email est incorrecte.";
		} else if(strlen("email") > 60) {
			$errors["email"] = "La taille de l'email doit être inférieure à 60 caractères.";
		}

		/*2. Contrôle du champ "Mot de passe" */

		/* 2.1 Contrôle du champ mot de passe*/
		if(!isset($password)){
			$errors["password"] = "Le champ \"Mot de passe\" doit être rempli.";
		}
		/* 2.2 Contrôle du champ confirmation*/
		else if(!isset($confirmPassword)){
			$errors["confirmPassword"] = "Le champ \"Confirmer le mot de passe\" doit être rempli.";
		}
		/* 2.3 Contrôle de l'égalité */
		else if($password !== $confirmPassword){
			$errors["confirmPassword"] = "Les mots de passe saisis sont différents.";
		} 
		/* 2.4 Contrôle de la taille du mot de passe*/
		else if ($password < 6) {
			$errors["password"] = "Le mot de passe choisi doit contenir au moins 6 caractères.";
		}
		/* 2.5 Contrôle du format du mot de passe*/
		else {
			// Le password contient au moins une lettre ?
			$containsLetter = preg_match('/[a-zA-Z]/', $password);
			// Le password contient au moins un chiffre ?
			$containsDigit  = preg_match('/\d/', $password);
			// Le password contient au moins un autre caractère ?
			$containsSpecial= preg_match('/[^a-zA-Z\d]/', $password);
			if(!$containsLetter || !$containsDigit || !$containsSpecial) {
				$errors['password'] = "Lemot de passe doit contenir au moins une lettre, un nombre et un caractère spécial.";
			}
		}

		/*3. Contrôle du champ "Nom" */

		if(!preg_match('/[a-zA-Z]{2,}/', $lname)){
			$errors["lname"] = "Le nom ne doit contenir que des lettres";
		}

		/*4. Contrôle du champ "Prénom" */

		/*5. Contrôle du champ "Adresse" */

		/*6. Contrôle du champ "Code postal" */

		/*7. Contrôle du champ "Ville" */

		/*8. Contrôle du champ "Téléphone" */
		
		print_r($_POST);
		print_r($errors);
	}
?>

<!-- Formulaire HTML -->

<!DOCTYPE html>
<html>
	<head>
		<title>Register</title>
		<!-- Bootstrap -->
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	</head>
	<body>
		<!-- Header -->
		<?php //require(__DIR__."") ?>
		<div class="container">
			<form method="post" action="#">
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" class="form-control" id="email" placeholder="email" name="email" required>
				</div>
				<div class="form-group">
					<label for="password">Mot de passe</label>
					<input type="password" class="form-control" id="password" placeholder="password" name="password" required>
				</div>
				<div class="form-group">
					<label for="confirmPassword">Confirmer mot de passe</label>
					<input type="password" class="form-control" id="confirmPassword" placeholder="confirm password" name="confirmPassword" required>
				</div>
				<div class="form-group">
					<label for="lname">Nom</label>
					<input type="text" class="form-control" id="lname" placeholder="lastname" name="lname" required>
				</div>
				<div class="form-group">
					<label for="fname">Prénom</label>
					<input type="text" class="form-control" id="fname" placeholder="firstname" name="fname" required>
				</div>
				<div class="form-group">
					<label for="address">Adresse</label>
					<input type="text" class="form-control" id="address" placeholder="address" name="address" required>
				</div>
				<div class="form-group">
					<label for="zipcode">Code postale</label>
					<input type="text" class="form-control" id="zipcode" placeholder="zipcode" name="zipcode" required>
				</div>
				<div class="form-group">
					<label for="town">Ville</label>
					<input type="text" class="form-control" id="town" placeholder="town" name="town" required>
				</div>
				<div class="form-group">
					<label for="phone">Téléphone</label>
					<input type="phone" class="form-control" id="phone" placeholder="phone" name="phone" required>
				</div>
				<button type="submit" class="btn btn-primary" name="submitBtn">Valider</button>
			</form>
		</div>
	</body>
</html>