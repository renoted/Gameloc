<?php

  session_start();
  require(__DIR__."/functions.php");
  $page = "Connexion";

  /*Instanciation du tableau d'erreurs*/
  $errors = [];

  /*Récupération et traitement pour la sécurité des données du formulaire*/
  if(isset($_POST["submitBtn"])){
    $email = trim(htmlentities($_POST["email"]));
    $password = trim(htmlentities($_POST["password"]));
  
    /*Instanciation du db2_tables(connection)au d'erreurs*/

    /*1. Contrôle du champ "email" 
    $checkEmailMessage = check_email_format_conforme($email);
    if($checkEmailMessage !== ""){
      $errors["email"] = $checkEmailMessage; 
    }*/

    /*1. Contrôle du champ "email" */
    $checkEmailMessage = check_email_format_conforme($email);
    if($checkEmailMessage !== ""){
      $errors["email"] = $checkEmailMessage; 
    }



    /*2. Contrôle du champ "password" */
    $checkPasswordMessage = check_password_format_conforme($password);
    if($checkPasswordMessage !== ""){
      $errors["password"] = $checkPasswordMessage; 
    }

    if(empty($errors)) {
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
          // On stocke le user en session après avoir retiré le password
          unset($resultUser['password']);
          $_SESSION['user'] = $resultUser;

          // On redirige l'utilisateur vers la page protégée profile.php
          header("Location: catalog.php");
          die();
        }

        else {
          // Bon utilisateur/ mauvais mot de passe.
          $errors['connexion'] = "mauvais utilisateur/mot de passe.";
        }
      }

      else {
        // Utilisateur inconnu.
        $errors['connexion'] = "mauvais utilisateur/mot de passe.";
      }
    }
  }


?>

<!-- Affichage header.php puis page Login -->
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

            <?php print_error_message($errors, "connexion"); ?>

            <div class="form-group">
              <label for="email">Adresse électronique</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Email">
              <?php print_error_message($errors, "email"); ?>
            </div>

            <div class="form-group">
              <label for="password">Mot de passe</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Password">
              <?php print_error_message($errors, "password"); ?>
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
