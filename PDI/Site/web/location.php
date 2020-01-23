<?php
    session_start();
    $_SESSION['id'];

    include '../inc/function.inc.php';
    include '../inc/fonctions_postgresql.inc.php';
    $bdd=connect_db();
    //Connexion à la BD puis récupération des informations du film et du client
    $client = client_by_login($_SESSION['id'], $bdd);
    $book = book_by_id($_GET['book'], $bdd);
    //Préparation de la requète et execution de celle-ci avec les variables
    $sql2=$bdd->prepare('SELECT * FROM seen WHERE login=? AND id_book=?');
    $sql2->execute(array($_SESSION['id'],$_GET['book']));
    $result=$sql2->fetch();
    //Si le résultat n'est pas vide la location existe déjà et on redirige l'utilisateur sur son Profil
    if (!empty($result)) {
      if ($result['sale_date'] === null) {
        $date = date('y'.'m'.'d');
        $sql=$bdd->prepare("UPDATE seen SET sale_date=? WHERE login=? AND id_book=?");
        $sql->execute(array($date,$_SESSION['id'],$_GET['book']));

        echo '<meta http-equiv="refresh" content="1;url=./profil.php"/>';
      }
      else {
        echo '<meta http-equiv="refresh" content="1;url=./profil.php"/>';

      }

    }
    else {
        $date = date('y'.'m'.'d');
        $sql=$bdd->prepare('INSERT INTO seen(login, id_book, sale_date) VALUES (:login, :id_book, :sale_date)');
        $sql->execute(array(
          "login" => $_SESSION['id'],
          "id_book" => $_GET['book'],
          "sale_date" => $date));

      //On redirige le client sur son profil
      echo '<meta http-equiv="refresh" content="1;url=./profil.php"/>';
    }



 ?>
