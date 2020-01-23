<?php session_start();?>
<!DOCTYPE html>
<?php
include '../inc/function.inc.php';
include '../inc/fonctions_postgresql.inc.php';
//connexion à la base de donnée
$bdd=connect_db();

?>

<html lang="en">


<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Admin - Nutflux</title>

  <!-- CSS -->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/heroic-features.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a href="../index.php"><img src="https://fontmeme.com/permalink/191120/25006fc216f3b7da02dff5990da90fe2.png" alt="nutflux-font" border="0"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#"><?php echo $_SESSION['login']; ?>
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

    <!-- Header -->
    <header class="jumbotron my-4">
      <h1 class="display-3">Panel de Gestion</h1>

      <fieldset>

        <legend>Rechercher un client</legend>

        <form class="input" action="./admin.php" method="post">
          <input type="text" name="rechcli" placeholder="Prenom Client Nom Client">
          <input type="submit" name="rechadm" value="Rechercher">
          <input type="submit" name="allclient" value="Afficher tout les clients">
          <input type="submit" name="locationcheck" value="Vérifier les locations">
        </form>

      </fieldset>


      <fieldset>

        <legend>Ajouter un film</legend>

        <form class="input" action="./admin.php" method="post">
          <input type="text" name="title" placeholder="Nom Film">
          <input type="text" name="release_date" placeholder="Année de sortie">
          <input type="text" name="duration" placeholder="Durée du Film (en minutes)">
          <input type="text" name="price" placeholder="Prix (en €)">
          <input type="text" name="resume" placeholder="Résumé du film">
          <select size="2" name="option_act[]" multiple>
            <!-- Tous les noms des acteurs-->
            <?php
            $actors=all_actor($bdd);
            if(empty($actors)){
              echo '<option value="" ></option>';
            }
            else{
              foreach ($actors as $row) {
                echo '<option value="'.$row['id_actor'].'" >'.$row['first_name_actor'].' '.$row['last_name_actor'].'</option>';
              }
            }

            ?>
          </select>
          <select size="2" name="option_real[]" multiple>
            <!-- Tous les noms de réalisateurs-->
            <?php
            $directors=all_director($bdd);
            if(empty($directors)){
              echo '<option value="" ></option>';
            }
            else{
              foreach ($directors as $row) {
                echo '<option value="'.$row['id_director'].'" >'.$row['first_name_director'].' '.$row['last_name_director'].'</option>';
              }
            }
            ?>
          </select>

          <input type="submit" name="add_movie" value="Ajouter">
        </form>
      </fieldset>
      <?php
      //AJoouter un film
      if(isset($_POST['add_movie'])){
        if(!empty($_POST['title']) && !empty($_POST['price']) && !empty($_POST['release_date']) && !empty($_POST['duration']) && !empty($_POST['resume'])){
          add_movie($_POST['title'], $_POST['release_date'], $_POST['duration'],
          $_POST['price'], $_POST['resume'], $_POST['option_act'], $_POST['option_real'], $bdd);
          echo '<meta http-equiv="refresh" content="1;url=./admin.php"/>';
        }
        else {
          echo "Veuillez remplir tous les champs, et n'oubliez pas de sélectionner des acteurs et un (ou des) réalisateur.";
        }
      } ?>

      <fieldset>
        <legend>Ajouter un acteur</legend>
        <form class="input" action="./admin.php" method="post">
          <input type="text" name="first_name_actor" placeholder="Prénom de l'acteur">
          <input type="text" name="name_actor" placeholder="Nom de l'acteur">
          <input type="submit" name="add_act" value="Ajouter">
        </form>
      </fieldset>
      <?php
      //Accès à la base de donnée et ajout d'un acteur
      if(isset($_POST['add_act'])){
        if(!empty($_POST['name_actor']) && !empty($_POST['first_name_actor'])){
          add_actor($_POST['name_actor'], $_POST['first_name_actor'], $bdd);
          echo '<meta http-equiv="refresh" content="1;url=./admin.php"/>';
        }
        else {
          echo "Veuillez remplir tous les champs.";
        }
      } ?>

      <fieldset>
        <legend>Ajouter un réalisateur</legend>
        <form class="input" action="./admin.php" method="post">
          <input type="text" name="first_name_director" placeholder="Prénom du réalisateur">
          <input type="text" name="name_director" placeholder="Nom du réalisateur">
          <input type="submit" name="add_dir" value="Ajouter">
        </form>
      </fieldset>
      <?php
      //Ajout d'un réalisateur
      if(isset($_POST['add_dir'])){
        if(!empty($_POST['name_director']) && !empty($_POST['first_name_director'])){
          add_director($_POST['name_director'], $_POST['first_name_director'], $bdd);
          echo '<meta http-equiv="refresh" content="1;url=./admin.php"/>';
        }
        else {
          echo "Veuillez remplir tous les champs.";
        }
      } ?>

      <fieldset>
        <legend>Supprimer un film</legend>
        <form class="input" action="./admin.php" method="post">
          <select name="option_del">
            <?php //database pour obtenir tout les films en option
            $del = all_movie($bdd);
            foreach ($del as $row) {
              echo '<option value="'.$row['id_movie'].'">'.$row['title'].'</option>';
            }
            ?>
          </select>
          <input type="submit" name="del_movie" value="Supprimer">
        </form>
      </fieldset>
      <?php
      if (isset($_POST['del_movie'])) {
        $selected_id = $_POST['option_del'];
        del_movie($selected_id, $bdd);
        echo '<meta http-equiv="refresh" content="1;url=./admin.php"/>';
      }
      ?>

    </header>
    <?php
    if(isset($_POST['rechadm']) AND $_POST['rechadm']=='Rechercher'){
      if(!isset($_POST['rechcli'])){
        echo "error404";
      }
      else {

        //$query = 'SELECT * FROM client WHERE last_name = $name';
        $donnee = client_by_name($_POST['rechcli'], $bdd);
        if(empty($donnee)){
          echo "<h2>Oups !</h2>\n<p>Votre recherche n'a pu aboutir veuillez réessayer.</p>";
        }
        else{
          echo "<table>
          <tr>
          <td>
          id_client
          </td>
          <td>
          Prénom Client
          </td>
          <td>
          Nom Client
          </td>
          <td>
          Adresse Mail
          </td>
          <td>
          Crédit
          </td>
          <td>
          Admin
          </td>
          </tr>
          ";

          foreach ($donnee as $row){
            echo "<tr>
            <td>"
            .$row['id_client'].
            "</td>
            <td>"
            .$row['first_name'].
            "</td>
            <td>"
            .$row['last_name'].
            "</td>
            <td>"
            .$row['email_address'].
            "</td>
            <td>"
            .$row['credit'].
            "</td>
            <td>"
            .$row['admin'].
            "</td>
            </tr>
            ";
          }
          echo "</table>";
        }
      }
    }
    if (isset($_POST['allclient'])) {


        //$query = 'SELECT * FROM client WHERE last_name = $name';
        $donnee = all_client($bdd);
        if(empty($donnee)){
          echo "<h2>Oups !</h2>\n<p>Votre recherche n'a pu aboutir veuillez réessayer.</p>";
        }

        echo "<table>
        <tr>
        <td>
        id_client
        </td>
        <td>
        Prénom Client
        </td>
        <td>
        Nom Client
        </td>
        <td>
        Adresse Mail
        </td>
        <td>
        Crédit
        </td>
        <td>
        Admin
        </td>
        </tr>
        ";

        foreach ($donnee as $row){
          echo "<tr>
          <td>"
          .$row['id_client'].
          "</td>
          <td>"
          .$row['first_name'].
          "</td>
          <td>"
          .$row['last_name'].
          "</td>
          <td>"
          .$row['email_address'].
          "</td>
          <td>"
          .$row['credit'].
          "</td>
          <td>"
          .$row['admin'].
          "</td>
          </tr>
          ";
        }
        echo "</table>";
        $credit=sum_credit($bdd);
        echo "<p>Total des crédits presents sur le site :".$credit['total']."";
      }

      if (isset($_POST['locationcheck'])) {
        check_location($bdd);
        echo "<p>Les locations ont été vérifiées</p>";
      }
    ?>
  </div>
  <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; LIGUORI & RADOLANIRINA</p>
    </div>
  </footer>

  <!-- JavaScript -->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>
</html>
