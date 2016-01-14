<?php
  session_start();
  $userConnecte = $_SESSION['user']['firstname']." ".$_SESSION['user']['lastname'];
  echo "Au revoir ". $userConnecte;
  // remise à blanc
  unset ($_SESSION['user']);
  
?>
