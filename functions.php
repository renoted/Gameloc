<?php
	
	require(__DIR__."/config/db.php");

	/*
		Fonction qui vérifie si le format d'un email est valide ou non.
		- Si valide, renvoi une chaîne vide ("").
		- Sinon renvoi le message d'erreur adéquat.
	*/
	function check_email_format($email) {
		global $pdo;
		if(empty($email)){
			return "Le champ \"Email\" doit être rempli."; 
		} else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			return "Le format de l'email est incorrecte.";
		} else if(strlen("email") > 60) {
			return "La taille de l'email doit être inférieure à 60 caractères.";
		} else {
			$query = $pdo->prepare("SELECT email FROM users  WHERE email = :email");
			$query->bindValue(":email", $email, PDO::PARAM_STR);
			$query->execute();
			$result = $query->fetch();
			if($result){
				return "Le mail est déjà présent dans la bdd.";
			} else {
				return "";
			}
		}
	}

	/*
		Fonction qui vérifie si le format d'un mot de passe est valide ou non.
		- Si valide, renvoi une chaîne vide ("").
		- Sinon renvoi le message d'erreur adéquat.
	*/
	function check_password_format($password, $confirmPassword) {
		/* 1 Contrôle du champ mot de passe*/
		if(empty($password)){
			return "Le champ \"Mot de passe\" doit être rempli.";
		}
		/* 2 Contrôle du champ confirmation*/
		else if(empty($confirmPassword)){
			return "Le champ \"Confirmer le mot de passe\" doit être rempli.";
		}
		/* 3 Contrôle de l'égalité */
		else if($password !== $confirmPassword){
			return "Les mots de passe saisis sont différents.";
		} 
		/* 4 Contrôle de la taille du mot de passe*/
		else if (strlen($password) < 6) {
			return "Le mot de passe choisi doit contenir au moins 6 caractères.";
		}
		/* 5 Contrôle du format du mot de passe*/
		else {
			// Le password contient au moins une lettre ?
			$containsLetter = preg_match('/[a-zA-Z]/', $password);
			// Le password contient au moins un chiffre ?
			$containsDigit  = preg_match('/\d/', $password);
			// Le password contient au moins un autre caractère ?
			$containsSpecial= preg_match('/[^a-zA-Z\d]/', $password);
			if(!$containsLetter || !$containsDigit || !$containsSpecial) {
				return "Le mot de passe doit contenir au moins une lettre, un nombre et un caractère spécial.";
			}
		}

		return "";
	}

	/*
		Fonction qui vérifie qu'une chaîne passée en paramètre une chaîne.
		- Si la chaîne est vide ou ne contient pas que des caractères, revoi le message d'erreur adéquat
		- Sinon revoi un chaîne vide
	*/
	function check_contains_characters_only($str){
		if(empty($str)){
			return "Ce champ doit être rempli.";
		} else if(preg_match('/[^a-zA-Z]/', $str)){
			return "Le champ ne doit contenir que des lettres.";
		} 
		else {
			return "";
		}
	}

	/*
		Fonction qui vérifie si un code postal est correctement formaté
	*/
	function check_zipcode_format($zipcode){
		if(empty($zipcode)){
			return "Ce champ doit être rempli.";
		} else if(strlen($zipcode) !== 5 || !ctype_digit($zipcode)){
			return "Le champ ne doit contenir que 5 chiffres";
		} else {
			return "";
		}
	}

	/*
		Fonction qui vérifie si un numéro de téléphone est correctement formaté
	*/
	function check_phone_nb_format($phoneNb){
		if(empty($phoneNb)){
			return "Ce champ doit être rempli.";
		} else if(!ctype_digit($phoneNb) || strlen($phoneNb) !== 10){
			return "Le numéro saisi n'est pas valide, il doit contenir 10 chiffres (ex: 0123456789).";
		} else {
			return "";
		}
	}

	/*
		Fonction prenant en paramètre le tableau d'erreur et le nom d'une clé de ce tableau.
		- Si cette clé existe, affiche le message correspondant.
	*/

	function print_error_message($errors, $error) {
		if(isset($errors[$error])){
			echo "<div class=\"alert alert-danger\">{$errors[$error]}</div>";
		}	
	}

	/*
	Pour enregistrer en bdd :
	* champs latitude : DECIMAL(10,8)
	* champs longitude : DECIMAL(11,8) 
*/

function geocode($address){

	// Url de l'api : https://maps.google.com/maps/api/geocode/json?address=

	// Encodage de l'adresse (" " remplacés pas "%")
	$address = urlencode($address);

	// Url de l'api pour geocoder
	$urlApi = "https://maps.google.com/maps/api/geocode/json?address=$address";

	// Apple de l'Api gmap decode (en GET - reponse en JSON
	$responseJson = file_get_contents($urlApi);

	// Décodage du json pour le transformer en array php associatif
	$responseArray = json_decode($responseJson, true);

	// Tableau associatif retourné par la fonction
	$response = [];

	// On teste si le résultat est valide
	if($responseArray["status"] === "OK"){
		$lat = $responseArray["results"]["0"]["geometry"]["location"]["lat"];
		$lng = $responseArray["results"]["0"]["geometry"]["location"]["lng"];

		if($lat && $lng){
			$response["lat"] = $lat;
			$response["lng"] = $lng;
		}
	}

	return $response;
}

	/*
		Cett fonction vérifie que l'utilisateur qui tente d'accçder à cette page est bien connecté.
		Si ce n'est pas le cas, il est renvoyé vers page d'accueil et on affecte à la variable globale
		$_SESSION une clé "message" avec un message d'erreur à afficher sur la page d'accueil.
	*/
	function check_logged_in(){
		if(!isset($_SESSION)) {
			session_start();
		}

		if(empty($_SESSION['user'])) {
			$_SESSION['message'] = "Vous devez vous connecter.";
			
			header("Location: index.php");
			die();
		}
	}

	function get_user_datas($email){
		$query = $pdo->prepare("SELECT * FROM users WHERE email = :email");
		$query->bindValue(":email", $email, PDO::PARAM_STR);
		$query->execute();
		$results = $query->fetch();
		return $results;
	}

?>