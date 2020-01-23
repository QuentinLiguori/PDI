<?php session_start();
include '../inc/function.inc.php';
include '../inc/fonctions_postgresql.inc.php';
//Connexion à la base de données
$bdd=connect_db();
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Ajouter des crédits - Nutflux</title>

  <!-- CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles -->
  <link href="../css/heroic-features.css" rel="stylesheet">

</head>

<body>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a href="./accueil"><img src="https://fontmeme.com/permalink/191120/25006fc216f3b7da02dff5990da90fe2.png" alt="nutflux-font" border="0"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <!-- Utilisation de la session pour afficher le nom du client afin d'acceder à son profil -->
            <a class="nav-link" href="./profil.php"><?php echo $_SESSION['login']; ?>
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item">

            <?php $client=client_by_id($_SESSION['id'],$bdd);
            // Récupération des informations du client connecté grâce à son id
            ?>
            <!-- Affichage du crédit du client et redirection vers la page pour en ajouter -->
            <a class="nav-link" href="./credit_change.php"><?php echo $client['credit']; ?>€</a>
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
      <h1 class="display-3">Recharger votre compte</h1>

      <fieldset>
        <!-- Formulaire Pour ajouter des crédits -->
        <legend>Ajouter du crédit </legend>

        <form class="input" action="./credit_change.php" method="post">
          <input type="number" name="new_credit" placeholder="Valeur de la recharge">
          <input type="submit" name="add_credit" value="Ajouter">
        </form>
      </fieldset>
    </header>


    <?php
    // Verifier si les champs ne sont pas vide
    if(isset($_POST['add_credit'])){
      if (!empty($_POST['new_credit'])) {
        add_credit($client, $_POST['new_credit'], $bdd);
        //Ajouter du crédit et rediriger vers la page du profil
        echo '<meta http-equiv="refresh" content="1;url=./profil.php"/>';
      }
    }
    ?>

  </div>
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; LIGUORI & RADOLANIRINA</p>
    </div>
    <!-- /.container -->
  </footer>

  <!-- Bootstrap core -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>





</body>
</html>
