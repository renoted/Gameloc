<?php

  session_start();

  require(__DIR__."/config/db.php");
  require(__DIR__."/functions.php");
  $page = "Connexion";

  /*Récupération des données du formulaire*/
  if(isset($_POST["submitBtn"])){
    $email = trim(htmlentities($_POST["email"]));
    $password = trim(htmlentities($_POST["password"]));
  
    /*Instanciation du tableau d'erreurs*/
    $errors = [];

    /*1. Contrôle du champ "Email" pour la sécurité */ 
    $checkEmailMessage = check_email_format($email);
    if($checkEmailMessage !== ""){
      $errors["email"] = $checkEmailMessage; 
    }

    /*2. Contrôle du champ "Mot de passe" pour la sécurité */

    $checkPasswordMessage = check_password_format($password, $confirmPassword);
    if($checkPasswordMessage !== ""){
      $errors["password"] = $checkPasswordMessage;
    }

     /*3. Recherche correspondance email/password dans la table users de la bdd */
    $query = $pdo->prepare('SELECT * FROM users WHERE email = :email');
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->execute();
    $resultUser = $query->fetch();

    // Si l'utilisateur a été trouvé
    if($resultUser) {
      // Compare un password en clair avec un password haché
      // Attention, PHP 5.5 ou plus !!! - Sinon, depuis 5.3.7 : https://github.com/ircmaxell/password_compat
      $isValidPassword = password_verify($password, $resultUser['password']);

      if($isValidPassword) {
        // On stocke le user en session et on retire le password avant (pas très grave)
        unset($resultUser['password']);
        $_SESSION['user'] = $resultUser;

        // On redirige l'utilisateur vers la page protégée profile.php
        header("Location: profile.php");
        die();
      }
      else {
        $errors['password'] = "Wrong password.";
      }
    }
    else {
      $errors['user'] = "User with email not found.";
    }

    $_SESSION['loginErrors'] = $errors;
    
    header("Location: index.php");
    die();
  }


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="public/img/logoGameloc.ico">

  <title>Login</title>

  <!-- Bootstrap core CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

  <!-- Custom styles for this template -->
  <link href="public/css/vendor/starter-template.css" rel="stylesheet">

  <link rel="stylesheet" href="public/css/main.css">


  <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
    </head>

    <body>

      <div class="jumbotron">
          <div class="container">
            <?php
            include 'include/header.php';
            ?>
           
          </div><!-- /.container -->
      </div><!-- /.jumbotron -->

      <!-- Copié de bootstrap : http://getbootstrap.com/css/#forms -->

      <div class="container">
        <form method="POST" action="#">
          <div class="form-group">
                  <label for="email">Adresse électronique</label>
                  <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                </div>

                <div class="form-group">
                  <label for="password">Mot de passe</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>
              <button type="submit" name="submitBtn" class="btn btn-primary btn-index">Valider</button>
        </form>
      </div><!-- /.container



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    
  </body>
</html>
