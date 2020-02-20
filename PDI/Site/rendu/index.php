<?php session_start();
include './inc/fonctions_postgresql.inc.php';
$bdd=connect_db();
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Connexion - Nutflux</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/heroic-features.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a href="./index.php"><img src="https://fontmeme.com/permalink/191120/25006fc216f3b7da02dff5990da90fe2.png" alt="nutflux-font" border="0"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#">Home
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">
<p></p>
<header class="jumbotron my-4">
  <h1 class="display-3">La référence des services de VOD</h1>

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
    	<p><input type="submit" value="Connexion" id="connect"/></p></form>

    	';
    }
    else
    {
        $message='';
        if (empty($_POST['login']) || empty($_POST['password']) ) //Oublie d'un champ
        {

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
        else //On check le mot de passe
        {
            /*if($_POST['password'] == 'lolo' && $_POST['login'] == 'yael'){

              echo '<meta http-equiv="refresh" content="1;url=./web/admin.php"/>';
              $_SESSION['login'] = yael;
              $_SESSION['password'] = lolo;
            }
            elseif ($_POST['password'] == 'lulu' && $_POST['login'] == 'quent') {
              echo '<meta http-equiv="refresh" content="1;url=./web/accueil.php"/>';
              $_SESSION['login'] = "quent";
              $_SESSION['password'] = "lulu";
            }
            else{
              echo '<form method="post" action="index.php">
            	<fieldset>
            	<legend>Connexion</legend>
            	<p>
            	<label for="pseudo">Login :</label><input name="login" type="text" id="login" /><br />
            	<label for="password">Mot de Passe :</label><input type="password" name="password" id="password" />
            	</p>
            	</fieldset>
            	<p><input type="submit" value="Connexion" id="connect"/></p></form>

            	';
              echo "<p>Mot de passe ou login erroné</p>";*/
              check_user_status($_POST['login'], $_POST['password'], $bdd);
            }
    /*	if ($data['membre_mdp'] == md5($_POST['password'])) // Acces OK !
    	{
    	    $_SESSION['login'] = $data['membre_pseudo'];
    	    $_SESSION['level'] = $data['membre_rang'];
    	    $_SESSION['id'] = $data['membre_id'];
    	    $message = '<p>Bienvenue '.$data['membre_pseudo'].',
    			vous êtes maintenant connecté!</p>
    			<p>Cliquez <a href="./index.php">ici</a>
    			pour revenir à la page d accueil</p>';
    	}
    	else // Acces pas OK !
    	{
    	    $message = '<p>Une erreur s\'est produite
    	    pendant votre identification.<br /> Le mot de passe ou le pseudo
                entré n\'est pas correcte.</p><p>Cliquez <a href="./connexion.php">ici</a>
    	    pour revenir à la page précédente
    	    <br /><br />Cliquez <a href="./index.php">ici</a>
    	    pour revenir à la page d accueil</p>';
    	}
        $query->CloseCursor();
      }*/
       //echo $message;

  }
    ?>



    </header>
  </div>

  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; Your Website 2019</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
