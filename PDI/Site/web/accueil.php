<?php session_start();?>
<!DOCTYPE html>
<?php
include '../inc/function.inc.php';
include '../inc/fonctions_postgresql.inc.php';
//Connect to the database
$bdd=connect_db();
?>

<html lang="en">


<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Accueil - Nom Bibliothèque</title>

  <!-- CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles -->
  <link href="../css/heroic-features.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a href="./accueil.php"><img src="" alt="Logo Bibliotheque en Ligne" border="0"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <!-- Use Session to print the name of the client and go to his personal page -->
            <a class="nav-link" href="./profil.php"><?php echo $_SESSION['login']; ?>
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <?php $client=client_by_login($_SESSION['id'],$bdd);
            // Retrieving client info using the client id
            ?>

          </li>
          <li class="nav-item">
            <a class="nav-link" href="./deconnexion.php">Deconnexion</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">

    <!-- Header -->
    <header class="jumbotron my-4">
      <h1 class="display-3">Rechercher les meilleurs Livres !</h1>

      <fieldset>
        <!-- Search Favorite Book Form -->
        <legend>Recherchez vos Livres préférés </legend>

        <form class="input" action="./accueil.php" method="post">
          <input type="text" name="recherche" placeholder="Titre Livre">
          <input type="submit" name="rechacc" value="Rechercher">
        </form>
      </fieldset>
    </header>


    <?php
    //Check if rechacc is set
    if(isset($_POST['rechacc'])){

      if ($_POST['type-validate'] == "titre") {
        //Récupère les livres en fonctions de leurs titres
        $donnee=book_by_title($_POST['recherche'],$bdd);
      }
      //check if $donnee is empty, and if not, we display the card of each book found
      if(empty($donnee)){
        echo "<h2>Oups !</h2>\n<p>Votre n'a pu aboutir veuillez réessayer.</p>";
      }
      else {
        //Print the books
        echo '  <div class="row text-center">';
        foreach ($donnee as $row) {
          display_book($row);
        }
        echo "</div>";
      }

    }
    else {
      $all_mov = all_book($bdd);
      //Si pas le bouton n'a pas été appuyé, on affiche tous les films
      echo '  <div class="row text-center">';
      foreach ($all_mov as $row) {
        display_book($row);
      }
      echo "</div>";
    }

    ?>

  </div>
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; LIGUORI & RADOLANIRINA </p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>





</body>
</html>
