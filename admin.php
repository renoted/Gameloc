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
$query = $pdo->prepare("SELECT count(id) as total FROM `users`;");
$query->execute();
$result = $query->fetch();

$nbUsers = $result["total"];

?>

<?php require(__DIR__."/include/header.php");?>

<!-- Statistiques -->
<div class="container">
	<h2>Statistique</h2>
	<p>Le site contient <?php echo $nbUsers; ?> utilisateur(s)</p>			
</div>
<!-- Carte google map -->
<div id="map"></div>

<script type="text/javascript">

    var map;

    var myLatLng = {lat: 48.8909964, lng: 2.2345892};

    function initMap() {
      map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 48.8588376, lng: 2.2773461},
        zoom: 12
      });

      var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        title: 'hello'
      });
    }

    </script>

    <script async defer
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApFHyhOE1lniNGNo0yrkthO-wEUp4OOzM&callback=initMap">
    </script>
</body>
</html>