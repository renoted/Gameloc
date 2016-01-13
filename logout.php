<?php
  session_start();
  $userConnecte = $_SESSION['user']['firstname']." ".$_SESSION['user']['lastname'];
  echo "Au revoir ". $userConnecte;
  // remise à blanc
  // TODO : la session ne semble pas fermer
  unset ($userConnecte, $_SESSION);
  
?>
