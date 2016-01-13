<?php


require(__DIR__."/functions.php");
require(__DIR__."/vendor/autoload.php");

$page = "Mot de passe oublié";
$errors = [];
$info = [];

if(isset($_POST["submitBtn"])){
	$email = trim(htmlentities($_POST["email"]));

	if(empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)){
		$errors["email"] = "format incorrect"; 
	}

	if(empty($errors)){
		$query = $pdo->prepare("SELECT * FROM users WHERE email = :email");
		$query->bindValue(":email", $email, PDO::PARAM_STR);
		$query->execute();
		$results = $query->fetch();
	}
	if($results){
		//Génération du token
		$token = md5(uniqid(mt_rand(), true));
		//Date d'expiration du token
		$expireToken = date("Y-m-d H:i:s", strtotime("+ 1 day"));
		//récupération de l'adresse ip
		$ip = $_SERVER["REMOTE_ADDR"];
		//on sauvegarde ces éléments dans la bdd
		$query = $pdo->prepare("UPDATE users SET token = :token, expire_token = :expireToken, ip = :ip WHERE id = :id");
		$query->bindValue(":token", $token, PDO::PARAM_STR);
		$query->bindValue(":expireToken", $expireToken, PDO::PARAM_STR);
		$query->bindValue(":ip", $ip, PDO::PARAM_STR);
		$query->bindValue(":id", $results["id"], PDO::PARAM_INT);
		$query->execute();

		//Si MAJ ok
		if($query->rowCount() > 0){
			$resetLink = "http://".$_SERVER['SERVER_NAME'].dirname($_SERVER['PHP_SELF'])."/resetPassword.php?token=".$token."&email=".$email;
			//Envoi de l'email
			$mail = new PHPMailer;
			$mail->isSMTP();                                      // Set mailer to use SMTP
			$mail->Host = 'smtp.mailgun.org';  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = 'postmaster@sandbox504c3f44050c4ee3aa785151b4924429.mailgun.org';                 // SMTP username
			$mail->Password = '5af02be0e52d7990ab876526bae4ba3e';                           // SMTP password
			$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
			$mail->Port = 587;                                    // TCP port to connect to

			$mail->setFrom('no-reply@aego.fr', 'Mailer');
			$mail->addAddress('ducreuxr@gmail.com');               // Name is optional

			$mail->isHTML(true);                                  // Set email format to HTML

			$mail->Subject = 'Réinitiliser votre mot de passe';
			$mail->Body    = 'Cliquez sur le lien suivant: '.$resetLink;

if(!$mail->send()) {
    $errors["email"] = 'Message could not be sent.';
} else {
    $info["email"] = 'Message has been sent';
}

		}
	} else {
		$errors['email'] = "pas dans la bdd";
	} 
}

?>

<?php require(__DIR__."/include/header.php");?>

<div class="container">

        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"] ?>">

            <div class="form-group">
              <label for="email">Adresse électronique</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Email">
            </div>
            <?php print_error_message($errors, "email") ?>
            <?php if(isset($info["email"])){echo '<div class="alert alert-info">'.$info["email"]."</div>";} ?>
            <button type="submit" name="submitBtn" class="btn btn-primary btn-index">Valider</button>
        </form>

      </div><!-- /.container

<?php require(__DIR__."/include/footer.php");?>