<?php

	$page = "catalogue";

	// require(__DIR__.'/config/db.php');    appelé ds check_Logged_in();
	require(__DIR__.'/functions.php');

	check_Logged_in();


?>
	<!-- On inclut le header ( <head> + début du <body> + jumbotron + logo) -->
  <?php include(__DIR__.'/include/header.php'); ?>

  	<div class="container-fluid">
		<div class="row">
	  	
	  		<!-- Création du bloc qui contient le formulaire -->
		  	<div class="col-md-3">
			  	<div id="divForm">			  	
					<!-- Formulaire -->
					<form id="form">
						  <div class="form-group">
						    <label for="search">Rechercher</label>
						    <input type="text" class="form-control" id="search" placeholder="Search">
						  </div>
						    
						  <!-- select box selected à "tous" par défaut -->							
						  
						    <label for="plateform">Plateforme</label>
							<select class="form-control" id="plateform" name="select">
							  <option value="value1" selected>Tous</option> 
							  <option value="value2">Xbox1</option>
							  <option value="value3">PC</option>
							  <option value="value3">PS4</option>
							</select>
						  						  
						  <div class="checkbox">
						    <label>
						      <input type="checkbox">Disponible immédiatement
						    </label>
						  </div>
						  <button type="submit" class="btn btn-primary">Rechercher</button>
					</form>
				</div><!-- /.divForm -->				
			</div><!-- /.col-md-3 -->

		<div class="col-md-9">

		</div>

		</div>
	</div>

  



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    
   </body>
 </html>
