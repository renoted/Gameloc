<?php

	session_start();

	require(__DIR__."/config/db.php");
	require(__DIR__."/functions.php");

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
		$checkEmailMessage = check_email_format($email);
		if($checkEmailMessage !== ""){
			$errors["email"] = $checkEmailMessage; 
		}

		/*2. Contrôle du champ "Mot de passe" */

		$checkPasswordMessage = check_password_format($password, $confirmPassword);
		if($checkPasswordMessage !== ""){
			$errors["password"] = $checkPasswordMessage;
		}

		/*3. Contrôle du champ "Nom" */

		$checkLnameMessage = check_contains_caracters_only($lname);
		if($checkLnameMessage !== ""){
			$errors["lname"] = $checkLnameMessage;
		}

		/*4. Contrôle du champ "Prénom" */

		$checkFnameMessage = check_contains_caracters_only($fname);
		if($checkFnameMessage !== ""){
			$errors["fname"] = $checkFnameMessage;
		}
		/*5. Contrôle du champ "Adresse" */

		/*6. Contrôle du champ "Code postal" */

		/*7. Contrôle du champ "Ville" */

		$checkTownMessage = check_contains_caracters_only($town);
		if($checkTownMessage !== ""){
			$errors["town"] = $checkTownMessage;
		}
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
					<input type="email" class="form-control" id="email" placeholder="email" name="email">
				</div>
				<div class="form-group">
					<label for="password">Mot de passe</label>
					<input type="password" class="form-control" id="password" placeholder="password" name="password">
				</div>
				<div class="form-group">
					<label for="confirmPassword">Confirmer mot de passe</label>
					<input type="password" class="form-control" id="confirmPassword" placeholder="confirm password" name="confirmPassword">
				</div>
				<div class="form-group">
					<label for="lname">Nom</label>
					<input type="text" class="form-control" id="lname" placeholder="lastname" name="lname">
				</div>
				<div class="form-group">
					<label for="fname">Prénom</label>
					<input type="text" class="form-control" id="fname" placeholder="firstname" name="fname">
				</div>
				<div class="form-group">
					<label for="address">Adresse</label>
					<input type="text" class="form-control" id="address" placeholder="address" name="address">
				</div>
				<div class="form-group">
					<label for="zipcode">Code postale</label>
					<input type="text" class="form-control" id="zipcode" placeholder="zipcode" name="zipcode">
				</div>
				<div class="form-group">
					<label for="town">Ville</label>
					<input type="text" class="form-control" id="town" placeholder="town" name="town">
				</div>
				<div class="form-group">
					<label for="phone">Téléphone</label>
					<input type="phone" class="form-control" id="phone" placeholder="phone" name="phone">
				</div>
				<button type="submit" class="btn btn-primary" name="submitBtn">Valider</button>
			</form>
		</div>
	</body>
</html>