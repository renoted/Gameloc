<?php

	session_start();

	require(__DIR__."/functions.php");

	$page = "Inscription";
	/*Instanciation du tableau d'erreurs*/
	$errors = [];

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

		$checkLnameMessage = check_contains_characters_only($lname);
		if($checkLnameMessage !== ""){
			$errors["lname"] = $checkLnameMessage;
		}

		/*4. Contrôle du champ "Prénom" */

		$checkFnameMessage = check_contains_characters_only($fname);
		if($checkFnameMessage !== ""){
			$errors["fname"] = $checkFnameMessage;
		}
		/*5. Contrôle du champ "Adresse" */
		if(empty($address)){
			$errors["address"] = "Ce champ doit être rempli.";
		}
		/*6. Contrôle du champ "Code postal" */

		$checkZipcodeMessage = check_zipcode_format($zipcode);
		if($checkZipcodeMessage !== ""){
			$errors["zipcode"] = $checkZipcodeMessage;
		}

		/*7. Contrôle du champ "Ville" */

		$checkTownMessage = check_contains_characters_only($town);
		if($checkTownMessage !== ""){
			$errors["town"] = $checkTownMessage;
		}

		/*8. Contrôle du champ "Téléphone" */
		$checkPhoneNbMessage = check_phone_nb_format($phone);
		if($checkPhoneNbMessage !== ""){
			$errors["phone"] = $checkPhoneNbMessage;
		}

		//Sile formulaire est bien rempli, on ajoute les données dans la bdd
		if(empty($errors)){
			/*On encode le mot de passe*/
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

			/*On prépare la requête d'insertion des données*/
			$query = $pdo->prepare("INSERT INTO `users`(`email`, `password`, `lastname`, `firstname`, `address`, `zipcode`, `town`, `phone`) 
									VALUES (:email, :password, :lname, :fname, :address, :zipcode, :town, :phone);");
			$query->bindValue(":email", $email, PDO::PARAM_STR);
			$query->bindValue(":password", $hashedPassword, PDO::PARAM_STR);
			$query->bindValue(":lname", $lname, PDO::PARAM_STR);
			$query->bindValue(":fname", $fname, PDO::PARAM_STR);
			$query->bindValue(":address", $address, PDO::PARAM_STR);
			$query->bindValue(":zipcode", $zipcode, PDO::PARAM_STR);
			$query->bindValue(":town", $town, PDO::PARAM_STR);
			$query->bindValue(":phone", $phone, PDO::PARAM_STR);

			/*On exécute la requête*/
			$query->execute();

			/*On envoi l'utilisateur vers la page catalogue*/
			header("Location: catalogue.php");
			die();
		}
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
		<?php require(__DIR__."/include/header.php") ?>
		<div class="container">
			<form method="post" action=<?php echo $_SERVER["PHP_SELF"] ?>>
				<div class="form-group">
					<label for="email">Email</label>
					<input type="email" class="form-control" id="email" placeholder="email" name="email"  value="<?php if(isset($email)) echo $email ?>">
				</div>
				<?php print_error_message($errors, "email"); ?>
				
				<div class="form-group">
					<label for="password">Mot de passe</label>
					<input type="password" class="form-control" id="password" placeholder="password" name="password">
				</div>
				<?php print_error_message($errors, "password"); ?>

				<div class="form-group">
					<label for="confirmPassword">Confirmer mot de passe</label>
					<input type="password" class="form-control" id="confirmPassword" placeholder="confirm password" name="confirmPassword">
				</div>

				<div class="form-group">
					<label for="lname">Nom</label>
					<input type="text" class="form-control" id="lname" placeholder="lastname" name="lname" value="<?php if(isset($lname)) echo $lname ?>">
				</div>
				<?php print_error_message($errors, "lname"); ?>

				<div class="form-group">
					<label for="fname">Prénom</label>
					<input type="text" class="form-control" id="fname" placeholder="firstname" name="fname" value="<?php if(isset($fname)) echo $fname ?>">
				</div>
				<?php print_error_message($errors, "fname"); ?>

				<div class="form-group">
					<label for="address">Adresse</label>
					<input type="text" class="form-control" id="address" placeholder="address" name="address" value="<?php if(isset($address)) echo $address ?>">
				</div>
				<?php print_error_message($errors, "address"); ?>

				<div class="form-group">
					<label for="zipcode">Code postale</label>
					<input type="text" class="form-control" id="zipcode" placeholder="zipcode" name="zipcode" value="<?php if(isset($zipcode)) echo $zipcode ?>">
				</div>
				<?php print_error_message($errors, "zipcode"); ?>

				<div class="form-group">
					<label for="town">Ville</label>
					<input type="text" class="form-control" id="town" placeholder="town" name="town" value="<?php if(isset($town)) echo $town ?>">
				</div>
				<?php print_error_message($errors, "town"); ?>

				<div class="form-group">
					<label for="phone">Téléphone</label>
					<input type="phone" class="form-control" id="phone" placeholder="phone" name="phone" value="<?php if(isset($phone)) echo $phone ?>">
				</div>
				<?php print_error_message($errors, "phone"); ?>

				<button type="submit" class="btn btn-primary" name="submitBtn">Valider</button>
			</form>
		</div>
	</body>
</html>