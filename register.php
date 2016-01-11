<?php
	//require(__DIR__."config/db.php");
?>
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
					<input type="email" class="form-control" id="email" placeholder="email" name="email" require>
				</div>
				<div class="form-group">
					<label for="password">Mot de passe</label>
					<input type="password" class="form-control" id="password" placeholder="password" name="password" require>
				</div>
				<div class="form-group">
					<label for="confirmPassword">Confirmer mot de passe</label>
					<input type="password" class="form-control" id="confirmPassword" placeholder="confirm password" name="confirmPassword" require>
				</div>
				<div class="form-group">
					<label for="lname">Nom</label>
					<input type="text" class="form-control" id="lname" placeholder="lastname" name="lname" require>
				</div>
				<div class="form-group">
					<label for="fname">Prénom</label>
					<input type="text" class="form-control" id="fname" placeholder="firstname" name="fname" require>
				</div>
				<div class="form-group">
					<label for="address">Adresse</label>
					<input type="text" class="form-control" id="address" placeholder="address" name="address" require>
				</div>
				<div class="form-group">
					<label for="zipcode">Code postale</label>
					<input type="text" class="form-control" id="zipcode" placeholder="zipcode" name="zipcode" require>
				</div>
				<div class="form-group">
					<label for="city">Ville</label>
					<input type="text" class="form-control" id="city" placeholder="city" name="city" require>
				</div>
				<div class="form-group">
					<label for="phone">Téléphone</label>
					<input type="phone" class="form-control" id="phone" placeholder="phone" name="phone" require>
				</div>
				<button type="submit" class="btn btn-primary" name="submitBtn">Valider</button>
			</form>
		</div>
	</body>
</html>