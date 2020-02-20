<?php
/***********************************Connexion***********************************/

//Fonction de connexion à la base de donnée
function connect_db(){
  try
  {
    // On se connecte à postgresSQL
    $bdd = new PDO('pgsql:host=10.40.128.23;port=5432; dbname=db2019l3i_qliguori', 'y2019l3i_qliguori','A123456*');
    return $bdd;
  }
  catch(Exception $e)
  {
    // En cas d'erreur, on affiche un message et on arrête tout
    die('Erreur : '.$e->getMessage());
  }
}
//Fonction d'Inscription
function create_user_status($login_seek, $password_seek,$firstname,$lastname,$age,$gender, $country, $sp_category, $bdd){

  //On prepare, et execute, une requete pour recuperer les informations du client d'adresse mail donnée en entrée
  $sql=$bdd->prepare("SELECT * FROM client  WHERE login='$login_seek'");
  $sql->execute();
  $result = $sql->fetch();
  //Si le login donné en entrée n'existe pas
  if (empty($result)) {
    echo $lastname;
    $sql2=$bdd->prepare("INSERT INTO client VALUES (:login, :password_client, :first_name, :last_name, :age, :gender, :country, :sp_category)");
    $sql2->bindParam(':login', $login_seek);
    $sql2->bindParam(':password_client', $password_seek);
    $sql2->bindParam(':first_name', $firstname);
    $sql2->bindParam(':last_name', $lastname);
    $sql2->bindParam(':age', $age);
    $sql2->bindParam(':gender', $gender);
    $sql2->bindParam(':country', $country);
    $sql2->bindParam(':sp_category', $sp_category);

    $sql2->execute();

    //On stock son prenom et son id dans des variables de session
    $_SESSION['login'] = $login_seek;
    $_SESSION['name'] = $firstname;
    //on le redirige vers la page accueil.php
      //echo '<meta http-equiv="refresh" content="1;url=./accueil.php"/>';
  }
  //Si le login existe
  else {
    //On réaffiche le formulaire et un message d'erreur
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
    <p>Erreur : Ce login existe deja.</p>
    ';
  }
}
//Fonction de connection
function check_user_status($login_seek, $password_seek, $bdd){
  //On prepare, et execute, une requete pour recuperer les informations du client d'adresse mail donnée en entrée
  $sql=$bdd->prepare("SELECT * FROM client  WHERE login=?");
  $sql->execute($login_seek);
  $result = $sql->fetch();
  //Si le mot de passe donnée en entrée correspond
  if (strcmp($password_seek, $result['password_client'])) {
      //On stock son prenom et son id dans des variables de session
      $_SESSION['login'] = $result['login'];
      $_SESSION['name'] = $result['first_name'];
      //on le redirige vers la page accueil.php
      echo '<meta http-equiv="refresh" content="1;url=./web/accueil.php"/>';
  }

  //Si le mot de passe ne correspond pas
  else {
    //On réaffiche le formulaire et un message d'erreur
    echo '<form method="post" action="index.php">
    <fieldset>
    <legend>Connexion</legend>
    <p>
    <label for="pseudo">Login :</label><input name="login" type="text" id="login" /><br />
    <label for="password">Mot de Passe :</label><input type="password" name="password" id="password" />
    </p>
    </fieldset>
    <p><input type="submit" value="Connexion" id="connect"/></p></form>
    <p>Erreur : login ou mot de passe erroné.</p>
    ';
  }
}

/************************************Client************************************/

//Fonction de selection de tous les clients
function all_client($bdd){
  //On execute la requete
  $sql = $bdd->query('SELECT * FROM client');

  //on selection tous les resultats et on les retourne
  $result = $sql->fetchall();
  return $result;
}

//Fonction de selection d'un client depuis son id
function client_by_login($login_seek, $bdd){
  //on prepare la requete
  $sql=$bdd->prepare("SELECT * FROM client  WHERE login='$login_seek'");

  //on execute la requete avec le parametre $id_seek
  $sql->execute();

  //on recupere et retourne le resultat
  $result = $sql->fetch();
  return $result;
}

//Fonction de selection d'un client depuis son nom
function client_by_name($name_seek, $bdd){
  $result=array( );
  /*on divise l'entrée de l'utilisateur por recuperer le prenom et le nom dans
  un tableu à deux entrées*/
  $name_part = explode(" ", $name_seek, 2);

  //Si on a bien le nom et le prenom on rentre dans la boucle
  if(count($name_part)>1){

    //On prepare la requete avec les parametre "?"
    $sql=$bdd->prepare("SELECT * FROM client  WHERE first_name=? AND last_name=?");

    //On execute la requete en remplacant les "?" par le prenom et le nom du client
    $sql->execute(array($name_part[0], $name_part[1]));
    $result = $sql->fetchall();
  }
  return $result;
}


/*************************************Book*************************************/

function seen_book($login, $book,$bdd){

  $sql2=$bdd->prepare('SELECT * FROM seen WHERE login=? AND id_book=?');
  $sql2->execute(array($login, $book));
  $result=$sql2->fetch();

  if (empty($result)) {
    $sql=$bdd->prepare('INSERT INTO seen(login, id_book) VALUES (:login, :id_book)');
    $sql->execute(array(
      "login" => $login,
      "id_book" => $book));
  }
}
/*
//Fonction d'ajout de film
function add_movie($title, $release_year, $duration, $price, $resume, $option_act, $option_dir, $bdd){

  //on prepare la requete avec les parametres :t, :y, :d, :p et :r
  $sql=$bdd->prepare('INSERT INTO movie (title, release_year, duration, price, resume) VALUES (:t, :y, :d, :p, :r)');

  //on execute la requete en remplacant les parametres
  $sql->execute(array("t" => $title, "y" => $release_year, "d" => $duration, "p" => $price, "r" => $resume));

  //on recupere l'id du film qu'on ient de creer
  $sql2=$bdd->prepare("SELECT id_movie FROM movie  WHERE title=:t");
  $sql2->execute(array("t" => $title));
  $result=$sql2->fetch();

  //on prepare les requetes d'ajout des relations de jeu et de réalisation
  $sql3=$bdd->prepare("INSERT INTO plays VALUES (:id_actor, :id_movie)");
  $sql4=$bdd->prepare("INSERT INTO direct VALUES (:id_director, :id_movie)");

  //pour chaque acteur selectionné, on crée une relation avec son id et celui du film
  foreach ($option_act as $row) {
    $sql3->execute(array( "id_actor" => $row, "id_movie" => $result['id_movie']));
  }

  //pour chaque réalisateur selectionné, on crée une relation avec son id et celui du film
  foreach ($option_dir as $row) {
    $sql4->execute(array("id_director" => $row, "id_movie" => $result['id_movie']));
  }

  echo 'Votre film à bien été créé.';
}


*/

//Fonction de selection de tous les livres
function all_book($bdd){
  $sql = $bdd->query('SELECT id_book, title FROM book');
  $result = $sql->fetchall();
  return $result;
}

//Fonction de selection d'un livres depuis son titre
function book_by_title($title_seek, $bdd){
  //On prepare la requete de selection
  $sql=$bdd->prepare("SELECT id_book, title FROM book  WHERE title LIKE ?");

  //On ajoute "%" avant et après le titre donné en entrée
  $title_try = '%'.$title_seek.'%';

  //on execute la recherche pour tous les livres qui contiennent le titre en entrée dans leur titre
  $sql->execute(array($title_try));
  $result = $sql->fetchall();
  return $result;
}

//Fonction de selection d'un livres depuis son id
function book_by_id($id_seek, $bdd){
  $sql=$bdd->prepare("SELECT * FROM book WHERE id_book='$id_seek'");
  $sql->execute();
  $result = $sql->fetch();
  return $result;
}

//Fonction de selection d'un livres depuis l'id d'un client
function book_by_client($id_seek, $bdd){

  //On prepare la requete pour recuperer les informations des livres loués par le client d'id "?"
  $sql=$bdd->prepare( "SELECT id_book, title FROM book WHERE id_book IN (SELECT id_book FROM seen  WHERE login= ? AND sale_date!=NULL)");

  //On l'execute avec l'id passée en entrée
  $sql->execute(array($id_seek));
  $result = $sql->fetchall();
  return $result;
}

/***********************************Author***********************************/

/*
//Fonction d'ajout d'un directeur
function add_director($last_name_wanted, $first_name_wanted, $bdd){
  //on prepare la requete de selection de réalisateur par nom et prenom

  $sql2=$bdd->prepare('SELECT id_director FROM director WHERE first_name_director=:f_n_d AND last_name_director=:l_n_d');

  //On verifie si le réalisateur existe deja
  $sql2->execute(array("f_n_d" => $first_name_wanted, "l_n_d" => $last_name_wanted));
  $result = $sql2->fetch();

  //Si il n'existe pas on prepare une requete d'insertion et on crée le nouveau réalisateur
  if(empty($result)){
    $sql=$bdd->prepare('INSERT INTO director(first_name_director, last_name_director) VALUES (:f_n_d, :l_n_d)');
    $sql->execute(array("f_n_d" => $first_name_wanted, "l_n_d" => $last_name_wanted));
    echo "Le réalisateur ".$_POST['first_name_director']." ".$_POST['name_director']." a été ajouté !";
  }

  //Si il existe, on prévient l'utilisateur
  else {
    echo "Le réalisateur ".$_POST['first_name_director']." ".$_POST['name_director']." existe déjà, rien n'a été ajouté !";
  }
}
*/

//Fonction de selection de tous les réalisateurs
function all_director($bdd){
  $sql = $bdd->query('SELECT id_author, first_name, last_name FROM author');
  $result = $sql->fetchall();
  return $result;
}

//Fonction de selection de auteur(s) depuis l'id d'un livre
function author_by_id_book($id_book, $bdd){
  //On prepare une requete pour recupere les nom et prenom des réalisateurs qui réalisent le livre d'id "?"
  $sql= $bdd->prepare('SELECT first_name, last_name FROM author INNER JOIN write
    ON author.id_author = write.id_author WHERE write.id_book=?');

  //On execute la requete avec l'id donnée en entrée
  $sql->execute(array($id_book));
  $result = $sql->fetchall();
  return $result;
}
?>
