<?php session_start();
include './inc/function.inc.php';
include './inc/fonctions_postgresql.inc.php';
//Fonction de connexion à la base de données
$bdd=connect_db();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Connexion - Bibiothèque en ligne</title>

  <!--CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles -->
  <link href="css/heroic-features.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a href="./index.php"><img src="" alt="Logo de Bibliotheque" border="0"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">

        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">
<p></p>
<header class="jumbotron my-4">
  <h1 class="display-3">La référence des services de librairie en ligne</h1>

    <?php
    if (!isset($_POST['login'])) //On verifie si l'utilisateur est déjà connecté
    {
    	echo '<form method="post" action="index.php">
    	<fieldset>
    	<legend>Connexion</legend>
    	<p>
    	<label for="pseudo">Login :</label><input name="login" type="text" id="login" /><br />
    	<label for="password">Mot de Passe :</label><input type="password" name="password" id="password" />
    	</p>
    	</fieldset>
    	<p><input type="submit" value="Connexion" id="connect"/></p>
      <p>Inscrivez vous</p>
      <p><input type="submit" value="Inscription" name="register id="register"/></p>
      </form>

    	';
    }
    else
    {
        if (isset($_POST['register']) )
        {
            echo '<meta http-equiv="refresh" content="1;url=./web/register.php"/>';
        }
        else {
            if (empty($_POST['login']) || empty($_POST['password'])) {
              echo '<form method="post" action="index.php">
            	<fieldset>
            	<legend>Connexion</legend>
            	<p>
            	<label for="pseudo">Login :</label><input name="login" type="text" id="login" /><br />
            	<label for="password">Mot de Passe :</label><input type="password" name="password" id="password" />
            	</p>
            	</fieldset>
            	<p><input type="submit" value="Connexion" id="connect"/></p></form>
              <p>Une erreur s\'est produite pendant votre identification.
              Vous devez remplir tous les champs.</p>
            	';
            }
            else //On check le login et le mot de passe
            {
                  check_user_status($_POST['login'], $_POST['password'], $bdd);
            }
        }

  }
    ?>
    </header>
  </div>

  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; LIGUORI & RADOLANIRINA</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core  -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
