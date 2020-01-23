<?php
//Fonction d'affiche d'un carte d'information d'un film
function display_movie($donnee){
//on recupere les données du film passées en entrée et on les affiche dans une carte
  echo '
  <div class="col-lg-3 col-md-6 mb-4">
    <div class="card h-100">
      <img class="card-img-top" src="../pictures/card_pic.png" alt="ok">
      <div class="card-body">
        <h4 class="card-title">'.$donnee['title'].'</h4>

      </div>
      <div class="card-footer">
        <a href="./location.php?movie='.$donnee['id_movie'].'" class="btn btn-primary">Louer</a>
        <a href="./film.php?movie='.$donnee['id_movie'].'" class="btn btn-primary">En savoir plus</a>
      </div>
    </div>
  </div>
  ';
}


 ?>
