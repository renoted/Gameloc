<?php 

session_start();

require(__DIR__."/functions.php");

check_logged_in();

$page = "Admin"; 


if($_SESSION["user"]["role"] !== "admin"){
    echo "Vous vous êtes égaré ?";
    header("HTTP/1.0 403 Forbidden");
    die();
}

/*Compter le nombre d'utilisateur dans la bdd*/
$query = $pdo->prepare("SELECT * FROM `users`;");
$query->execute();
$results = $query->fetchAll();

/*Compter le nombre d'utilisateurs*/
$nbUsers = count($results);
?>

<?php require(__DIR__."/include/header.php");?>

<!-- Statistiques -->
<h1>Statistique</h1>
<p>Le site contient <?php echo $nbUsers; ?> utilisateur(s)</p>			
<!-- Carte google map -->
<h1>Localisation des utilisateurs</h1>
<div id="map"></div>
<!-- Derniers jeux ajoutés -->
<h1>Les derniers jeux ajoutés par les nouveaux inscrits</h1>
<!-- Ajouter les derniers jeux -->


<script src="public/js/map.js" type="text/javascript" async defer></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApFHyhOE1lniNGNo0yrkthO-wEUp4OOzM&callback=initMap" async defer></script>
</body>
</html>