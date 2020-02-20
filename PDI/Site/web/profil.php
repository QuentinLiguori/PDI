<?php session_start(); ?>
<!DOCTYPE html>
<?php
include '../inc/function.inc.php';
include '../inc/fonctions_postgresql.inc.php';

$bdd=connect_db();
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Mon Profil - Ma bibliotheque en ligne</title>

  <!-- CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles -->
  <link href="../css/heroic-features.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a href="./accueil.php"><img src="" alt="Logo Bibliothèque en ligne" border="0"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#"><?php echo $_SESSION['name']; ?>
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">
            <?php $client=client_by_login($_SESSION['login'],$bdd); ?>

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
    <p></p>
        <header class="jumbotron my-4">
            <h1 class="display-3">Bienvenue <?php echo $_SESSION['name']; ?> !</h1>
            <h2>Parcourez tout les livres de votre bibliotheque</h2>
        </header>

        <?php
          //affiche tous les films appartenant au client
          echo '  <div class="row text-center">';
          $book = book_by_client($_SESSION['login'], $bdd);
          foreach ($book as $row) {
            display_own_book($row);
          }
          echo "</div>";
        ?>
  </div>

  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; LIGUORI & RADOLANIRINA</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
