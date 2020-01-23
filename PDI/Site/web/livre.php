<?php session_start(); ?>
<!DOCTYPE html>
<?php
include '../inc/fonctions_postgresql.inc.php';

$bdd=connect_db();
?>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <?php
  $donnee = book_by_id($_GET['book'],$bdd);
  seen_book($donnee['id_book'],$_SESSION['id'],$bdd);
  ?>
  <title><?php echo $donnee['title'] ?> - Bibliotèque en ligne</title>

  <!-- Bootstrap core CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="../css/heroic-features.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a href="./accueil.php"><img src="" alt="Logo Librairie en Ligne" border="0"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="./profil.php"><?php echo $_SESSION['login']; ?>
              <span class="sr-only">(current)</span>
            </a>
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
            <h1 class="display-3"> <?php echo $donnee['title']; ?> !</h1>
            <h2>Résumé</h2>
            <p><?php echo $donnee['resume']; ?></p>
            <p>Année de sortie : <?php echo $donnee['release_year']; ?> </p>
            <p>Auteur : <?php
                //$author =author_by_id_book($donnee['id_book'],$bdd);
                //echo $author['first_name'];
                //echo $author['last_name'];
             ?></p>
            <p>Genre : <?php echo $donnee['genre']; ?>
              <form class="" action="livre.php?book=<?php echo $_GET['book']; ?>" method="post">
            <input type="submit" name="buy" value="Acheter">
            </form>
            <?php if (isset($_POST['buy'])) {
              echo '<meta http-equiv="refresh" content="1;url=./location.php?book='.$donnee['id_book'].'"/>';
            } ?>

        </header>
        <h2>Score du Livre</h2>

  </div>

  <!-- Footer -->
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; LIGUORI & RADOLANIRINA</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
