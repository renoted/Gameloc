<?php
	
	/*
		Fonction qui vérifie si le format d'un email est valide ou non.
		- Si valide, renvoi une chaîne vide ("").
		- Sinon renvoi le message d'erreur adéquat.
	*/
	function check_email_format($email) {
		if(!isset($email)){
			return "Le champ \"Email\" doit être rempli."; 
		} else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			return "Le format de l'email est incorrecte.";
		} else if(strlen("email") > 60) {
			return "La taille de l'email doit être inférieure à 60 caractères.";
		}
		return "";
	}

	/*
		Fonction qui vérifie si le format d'un mot de passe est valide ou non.
		- Si valide, renvoi une chaîne vide ("").
		- Sinon renvoi le message d'erreur adéquat.
	*/
	function check_password_format($password, $confirmPassword) {
		/* 1 Contrôle du champ mot de passe*/
		if(!isset($password)){
			return "Le champ \"Mot de passe\" doit être rempli.";
		}
		/* 2 Contrôle du champ confirmation*/
		else if(!isset($confirmPassword)){
			return "Le champ \"Confirmer le mot de passe\" doit être rempli.";
		}
		/* 3 Contrôle de l'égalité */
		else if($password !== $confirmPassword){
			return "Les mots de passe saisis sont différents.";
		} 
		/* 4 Contrôle de la taille du mot de passe*/
		else if ($password < 6) {
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

?>