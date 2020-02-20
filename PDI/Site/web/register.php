<?php session_start();
include '../inc/function.inc.php';
include '../inc/fonctions_postgresql.inc.php';
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

  <title>Inscription - Bibiothèque en ligne</title>

  <!--CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles -->
  <link href="../css/heroic-features.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a href="../index.php"><img src="" alt="Logo de Bibliotheque" border="0"></a>
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
    if (!isset($_POST['loginreg'])) //On verifie si l'utilisateur est déjà connecté
    {
      echo '<form method="post" action="register.php" id="formreg">
      <fieldset>
      <legend>Inscription</legend>
      <p>
      <label for="pseudo">Login :</label><input name="loginreg" type="text" id="loginreg" /><br />
      <label for="password">Mot de Passe :</label><input type="password" name="password" id="password" />
      <label for="firstname">Prénom :</label><input type="text" name="firstname" id="firstname" />
      <label for="lastname">Nom :</label><input type="text" name="lastname" id="lastname" />
      <label for="age">Age :</label><input type="number" name="age" id="age" />

      <label for="genre">Genre :</label>
      Monsieur<input type="radio" name="gender" id="man" value="m" checked/>
      Madame<input type="radio" name="gender" id="woman" value="f"/>

      <label for="country">Pays :</label><input type="text" name="country" id="country" />
      <label for="sp_category">Catégorie Socio-Professionelles :</label><input type="radio" name="sp_category" id="sp_category1" value="Agriculteurs exploitants" checked/>
      Artisants, Commercants, Chef d\'entreprise <input type="radio" name="sp_category" id="sp_category2" value="Artisans, commerçants, chefs d entreprise"/>
      Cadres et Profession Intellectulles Supèrieures <input type="radio" name="sp_category" id="sp_category3" value="Cadres et professions intellectuelles supérieures"/>
      Professions Intermediaires <input type="radio" name="sp_category" id="sp_category4" value="Professions intermédiaires"/>
      Employés <input type="radio" name="sp_category" id="sp_category5" value="Employés"/>
      Ouvrier <input type="radio" name="sp_category" id="sp_category6" value="Ouvriers"/>
      Retraités <input type="radio" name="sp_category" id="sp_category7" value="Retraités"/>
      Autres/Sans Activités Professionelles <input type="radio" name="sp_category" id="sp_category8" value="Autres sans activité professionnelle"/>

      </p>
      </fieldset>
      <p><input type="submit" value="Inscription" id="register"/></p></form>
      ';
    }
    else
    {
        if (empty($_POST['loginreg']) || empty($_POST['password']) || empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['age']) || empty($_POST['country'])) //Oublie d'un champ
        {

          echo '<form method="post" action="register.php" id="formreg">
          <fieldset>
          <legend>Inscription</legend>
          <p>
          <label for="pseudo">Login :</label><input name="loginreg" type="text" id="loginreg" /><br />
          <label for="password">Mot de Passe :</label><input type="password" name="password" id="password" />
          <label for="firstname">Prénom :</label><input type="text" name="firstname" id="firstname" />
          <label for="lastname">Nom :</label><input type="text" name="lastname" id="lastname" />
          <label for="age">Age :</label><input type="number" name="age" id="age" />

          <label for="genre">Genre :</label>
          Monsieur<input type="radio" name="gender" id="man" value="m" checked/>
          Madame<input type="radio" name="gender" id="woman" value="f"/>

          <label for="country">Pays :</label><input type="text" name="country" id="country" />
          <label for="sp_category">Catégorie Socio-Professionelles :</label><input type="radio" name="sp_category" id="sp_category1" value="Agriculteurs exploitants" checked/>
          Artisants, Commercants, Chef d\'entreprise <input type="radio" name="sp_category" id="sp_category2" value="Artisans, commerçants, chefs d entreprise"/>
          Cadres et Profession Intellectulles Supèrieures <input type="radio" name="sp_category" id="sp_category3" value="Cadres et professions intellectuelles supérieures"/>
          Professions Intermediaires <input type="radio" name="sp_category" id="sp_category4" value="Professions intermédiaires"/>
          Employés <input type="radio" name="sp_category" id="sp_category5" value="Employés"/>
          Ouvrier <input type="radio" name="sp_category" id="sp_category6" value="Ouvriers"/>
          Retraités <input type="radio" name="sp_category" id="sp_category7" value="Retraités"/>
          Autres/Sans Activités Professionelles <input type="radio" name="sp_category" id="sp_category8" value="Autres sans activité professionnelle"/>

          </p>
          </fieldset>
          <p><input type="submit" value="Inscription" id="register"/></p></form>
            <p>Une erreur s\'est produite pendant votre identification.
            Vous devez remplir tous les champs.</p>
          	';

        }
        else //On crée l'utilisateur dans la base de données
        {
            create_user_status($_POST['loginreg'], $_POST['password'],$_POST['firstname'],$_POST['lastname'], $_POST['age'], $_POST['gender'], $_POST['country'], $_POST['sp_category'], $bdd);
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
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
