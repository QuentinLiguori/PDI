<?php
//Fonction d'affiche d'un carte d'information d'un film
function display_book($donnee){
  echo '
  <div class="col-lg-3 col-md-6 mb-4">
  <div class="card h-100">
  <img class="card-img-top" src="../pictures/card_pic.png" alt="Immage non atteignable">
  <div class="card-body">
  <h4 class="card-title">'.$donnee['title'].'</h4>

  </div>
  <div class="card-footer">
  <a href="./location.php?book='.$donnee['id_book'].'" class="btn btn-primary">Acheter</a>
  <a href="./livre.php?book='.$donnee['id_book'].'" class="btn btn-primary">En savoir plus</a>
  </div>
  </div>
  </div>
  ';
}

function display_own_book($donnee){
  echo '
  <div class="col-lg-3 col-md-6 mb-4">
  <div class="card h-100">
  <img class="card-img-top" src="../pictures/card_pic.png" alt="Immage non atteignable">
  <div class="card-body">
  <h4 class="card-title">'.$donnee['title'].'</h4>

  </div>
  <div class="card-footer">
  <a href="./livre.php?book='.$donnee['id_book'].'" class="btn btn-primary">En savoir plus</a>
  </div>
  </div>
  </div>
  ';
}

function is_Over($array, $score){
  foreach ($array as $key => $value) {
    if ($value<$score) {
      unset($array[$key]);
      return TRUE;
    }
  }
  return FALSE;
}

function book_fame($login, $book, $bdd){
  $sql=$bdd->prepare("SELECT COUNT(*) FROM seen WHERE id_book=(SELECT id_book WHERE author = ?) AND sale_date IS NOT NULL");
  $sql->execute($book['author']);
  $authorFame = $sql->fetch();

  return ($book['score']+$authorFame)/2;
}

function book_user_nat($login, $book, $bdd){
  $natScore=0;
  //la langue de rédaction du livre et le pays de résidence de l'utilisateur
  $codes = [
    'ab' => 'Abkhazian',
    'aa' => 'Afar',
    'af' => 'Afrikaans',
    'ak' => 'Akan',
    'sq' => 'Albanian',
    'am' => 'Amharic',
    'ar' => 'Arabic',
    'an' => 'Aragonese',
    'hy' => 'Armenian',
    'as' => 'Assamese',
    'av' => 'Avaric',
    'ae' => 'Avestan',
    'ay' => 'Aymara',
    'az' => 'Azerbaijani',
    'bm' => 'Bambara',
    'ba' => 'Bashkir',
    'eu' => 'Basque',
    'be' => 'Belarusian',
    'bn' => 'Bengali',
    'bh' => 'Bihari languages',
    'bi' => 'Bislama',
    'bs' => 'Bosnian',
    'br' => 'Breton',
    'bg' => 'Bulgarian',
    'my' => 'Burmese',
    'ca' => 'Catalan, Valencian',
    'km' => 'Central Khmer',
    'ch' => 'Chamorro',
    'ce' => 'Chechen',
    'ny' => 'Chichewa, Chewa, Nyanja',
    'zh' => 'Chinese',
    'cu' => 'Church Slavonic, Old Bulgarian, Old Church Slavonic',
    'cv' => 'Chuvash',
    'kw' => 'Cornish',
    'co' => 'Corsican',
    'cr' => 'Cree',
    'hr' => 'Croatian',
    'cs' => 'Czech',
    'da' => 'Danish',
    'dv' => 'Divehi, Dhivehi, Maldivian',
    'nl' => 'Dutch, Flemish',
    'dz' => 'Dzongkha',
    'en' => 'English',
    'eo' => 'Esperanto',
    'et' => 'Estonian',
    'ee' => 'Ewe',
    'fo' => 'Faroese',
    'fj' => 'Fijian',
    'fi' => 'Finnish',
    'fr' => 'French',
    'ff' => 'Fulah',
    'gd' => 'Gaelic, Scottish Gaelic',
    'gl' => 'Galician',
    'lg' => 'Ganda',
    'ka' => 'Georgian',
    'de' => 'German',
    'ki' => 'Gikuyu, Kikuyu',
    'el' => 'Greek (Modern)',
    'kl' => 'Greenlandic, Kalaallisut',
    'gn' => 'Guarani',
    'gu' => 'Gujarati',
    'ht' => 'Haitian, Haitian Creole',
    'ha' => 'Hausa',
    'he' => 'Hebrew',
    'hz' => 'Herero',
    'hi' => 'Hindi',
    'ho' => 'Hiri Motu',
    'hu' => 'Hungarian',
    'is' => 'Icelandic',
    'io' => 'Ido',
    'ig' => 'Igbo',
    'id' => 'Indonesian',
    'ia' => 'Interlingua (International Auxiliary Language Association)',
    'ie' => 'Interlingue',
    'iu' => 'Inuktitut',
    'ik' => 'Inupiaq',
    'ga' => 'Irish',
    'it' => 'Italian',
    'ja' => 'Japanese',
    'jv' => 'Javanese',
    'kn' => 'Kannada',
    'kr' => 'Kanuri',
    'ks' => 'Kashmiri',
    'kk' => 'Kazakh',
    'rw' => 'Kinyarwanda',
    'kv' => 'Komi',
    'kg' => 'Kongo',
    'ko' => 'Korean',
    'kj' => 'Kwanyama, Kuanyama',
    'ku' => 'Kurdish',
    'ky' => 'Kyrgyz',
    'lo' => 'Lao',
    'la' => 'Latin',
    'lv' => 'Latvian',
    'lb' => 'Letzeburgesch, Luxembourgish',
    'li' => 'Limburgish, Limburgan, Limburger',
    'ln' => 'Lingala',
    'lt' => 'Lithuanian',
    'lu' => 'Luba-Katanga',
    'mk' => 'Macedonian',
    'mg' => 'Malagasy',
    'ms' => 'Malay',
    'ml' => 'Malayalam',
    'mt' => 'Maltese',
    'gv' => 'Manx',
    'mi' => 'Maori',
    'mr' => 'Marathi',
    'mh' => 'Marshallese',
    'ro' => 'Moldovan, Moldavian, Romanian',
    'mn' => 'Mongolian',
    'na' => 'Nauru',
    'nv' => 'Navajo, Navaho',
    'nd' => 'Northern Ndebele',
    'ng' => 'Ndonga',
    'ne' => 'Nepali',
    'se' => 'Northern Sami',
    'no' => 'Norwegian',
    'nb' => 'Norwegian Bokmål',
    'nn' => 'Norwegian Nynorsk',
    'ii' => 'Nuosu, Sichuan Yi',
    'oc' => 'Occitan (post 1500)',
    'oj' => 'Ojibwa',
    'or' => 'Oriya',
    'om' => 'Oromo',
    'os' => 'Ossetian, Ossetic',
    'pi' => 'Pali',
    'pa' => 'Panjabi, Punjabi',
    'ps' => 'Pashto, Pushto',
    'fa' => 'Persian',
    'pl' => 'Polish',
    'pt' => 'Portuguese',
    'qu' => 'Quechua',
    'rm' => 'Romansh',
    'rn' => 'Rundi',
    'ru' => 'Russian',
    'sm' => 'Samoan',
    'sg' => 'Sango',
    'sa' => 'Sanskrit',
    'sc' => 'Sardinian',
    'sr' => 'Serbian',
    'sn' => 'Shona',
    'sd' => 'Sindhi',
    'si' => 'Sinhala, Sinhalese',
    'sk' => 'Slovak',
    'sl' => 'Slovenian',
    'so' => 'Somali',
    'st' => 'Sotho, Southern',
    'nr' => 'South Ndebele',
    'es' => 'Spanish, Castilian',
    'su' => 'Sundanese',
    'sw' => 'Swahili',
    'ss' => 'Swati',
    'sv' => 'Swedish',
    'tl' => 'Tagalog',
    'ty' => 'Tahitian',
    'tg' => 'Tajik',
    'ta' => 'Tamil',
    'tt' => 'Tatar',
    'te' => 'Telugu',
    'th' => 'Thai',
    'bo' => 'Tibetan',
    'ti' => 'Tigrinya',
    'to' => 'Tonga (Tonga Islands)',
    'ts' => 'Tsonga',
    'tn' => 'Tswana',
    'tr' => 'Turkish',
    'tk' => 'Turkmen',
    'tw' => 'Twi',
    'ug' => 'Uighur, Uyghur',
    'uk' => 'Ukrainian',
    'ur' => 'Urdu',
    'uz' => 'Uzbek',
    've' => 'Venda',
    'vi' => 'Vietnamese',
    'vo' => 'Volap_k',
    'wa' => 'Walloon',
    'cy' => 'Welsh',
    'fy' => 'Western Frisian',
    'wo' => 'Wolof',
    'xh' => 'Xhosa',
    'yi' => 'Yiddish',
    'yo' => 'Yoruba',
    'za' => 'Zhuang, Chuang',
    'zu' => 'Zulu'
  ];

  $sql=$bdd->prepare("SELECT country FROM client WHERE login= $login");
  $sql->execute();
  $country= $sql->fetch();

  if ($country==$codes[$book['lang']]) {
    $natScore +=10 ;
  }

  //le genre du livre et le sexe de l'utilisateur
  $genre=[
    'Societe' => 'm',
    'Jeunesse' => 'f',
    'Art et éducation' => 'f',
    'BD' => 'f, m',
    'Cuisine' => 'f',
    'Érotisme' => 'f, m',
    'Fantasy Terreur' => 'm',
    'Histoire' => 'm',
    'Spiritualité' => 'f, m',
    'Romans' => 'f, m',
    'Policier' => 'm',
    'Romance' => 'f',
    'Sciences' => 'm',
    'Sciences-Fiction' => 'm'
  ];

  $sql2=$bdd->prepare("SELECT gender FROM client WHERE login= $login");
  $sql2->execute();
  $sexe= $sql2->fetch();

  if ($genre[$book['genre']]==$sexe) {
    $natScore +=10 ;
  }

  //l'année de sortie du livre et l'âge de l'utilisateur
  $sql3=$bdd->prepare("SELECT age FROM client WHERE login= $login");
  $sql3->execute();
  $age= $sql3->fetch();
  $now=idate(Y);

  if (($book['release_year']>=$now-($age-20)) && ($book['release_year']<=$now-($age+20))) {
    $natScore +=10 ;
  }


  //le prix du livre et la catégorie socio-professionnelle de l'utilisateur
  $sql3=$bdd->prepare("SELECT sp_category FROM client WHERE login= $login");
  $sql3->execute();
  $spCat= $sql3->fetch();

  if ($spCat=="Autres sans activité professionnelle" && $book['price']<=8) {
    $natScore +=10 ;
  }
  elseif ($spCat=="Ouvriers" && $book['price']<=10) {
    $natScore +=10 ;
  }
  elseif ($spCat=="Employés" && $book['price']<=12.5) {
    $natScore +=10 ;
  }
  elseif ($spCat=="Agriculteurs exploitants" && $book['price']<=14.5) {
    $natScore +=10 ;
  }
  elseif ($spCat=="Professions intermédiaires" && $book['price']<=17) {
    $natScore +=10 ;
  }
  elseif ($spCat=="Retraités" && $book['price']<=20) {
    $natScore +=10 ;
  }
  elseif ($spCat=="Artisans, commerçants, chefs d entreprise" && $book['price']<=25) {
    $natScore +=10 ;
  }
  elseif ($spCat=="Cadres et professions intellectuelles supérieures") {
    $natScore +=10 ;
  }

  return $natScore;
}

function similar_profil($login, $bdd){
  $sql=$bdd->prepare("SELECT login FROM client WHERE age=? AND gender=? AND country=? AND sp_category=?");
  $sql->execute($login['age'], $login['gender'], $login['country'], $login['sp_category']);
  $similarP= $sql->fetchall();
}


function book_user_dyn($login, $book, $bdd){
  $dynScore=0;
  //que le prix du livre ne dépasse pas la dépense maximale de l'utilisateur
  $sql=$bdd->prepare("SELECT MAX(price) FROM book WHERE id_book=(SELECT id_book FROM seen WHERE id_client=$login AND sale_date IS NOT NULL)");
  $sql->execute();
  $max= $sql->fetch();

  if($max>=$book['price']){
    $dynScore+=20;
  }

  //que l'auteur, le genre et/ou l'année de parution soient représentatif de l'historique d'achat de l'utilisateur (sous-fonction ?)
  $sql2=$bdd->prepare("SELECT * FROM book WHERE id_book=(SELECT id_book FROM seen WHERE id_client=$login AND sale_date IS NOT NULL)");
  $sql2->execute();
  $bookbought= $sql2->fetchall();

  foreach ($bookbought as $bookB) {
    if ($bookB['author']==$book['author']) {
      $dynScore+=20;
    }
    if ($bookB['genre']==$book['genre']) {
      $dynScore+=20;
    }
    if ($bookB['release_year']==$book['release_year']) {
      $dynScore+=20;
    }
  }

  //si le livre est une des œuvres consultées par l'utilisateur ou non
  $sql3=$bdd->prepare("SELECT * FROM seen WHERE id_book = ? AND id_client = ? AND sale_date IS NULL)");
  $sql3->execute($book['id_book'], $login);

  if($sql3->fetch()){
    $dynScore+=20;
  }

  //si le livre est présent dans l'historique d'achat des profils similaires à celui de l'utilisateur (dur)
  $similarP=similar_profil($login, $bdd);
  foreach ($similarP as $profil) {
    $sql4=$bdd->prepare("SELECT * FROM seen WHERE id_book = ? AND id_client = ? AND sale_date IS NOT NULL)");
    $sql4->execute($book['id_book'], $profil['login']);

    if($sql4->fetch()){
      $i++;
    }
    else {
      $j++;
    }
  }
  if ($i>$j) {
      $dynScore+=20;
  }

  return $dynScore;
}


function book_temp( $book, $bdd){
  $tempScore=0;
  //Selon la période de l’année, des genres plus mis en avant que d’autres
  


  //Les tendances sont calculées en fonction du nombre de livres vendu sur un mois



  return $tempScore;
}

function suggested_Books($login, $bdd){
  $suggestBooks = array('0' => 0);

  $sql=$bdd->prepare("SELECT * FROM book");
  $books = ($sql->execute())->fetchall();

  foreach ($books as $book) {
    $bookSScore = book_fame($login, $book, $bdd);
    $bookSScore += book_user_nat($login, $book, $bdd);
    $bookSScore += book_user_dyn($login, $book, $bdd);
    $bookSScore += book_temp( $book, $bdd);

    if (count($suggestBooks)<5) {
      $suggestBooks[$book['id_book']] = $bookSScore;
    }
    elseif (is_Over($suggestBooks, $bookSScore)) {
      $suggestBooks[$book['id_book']] = $bookSScore;
    }
  }

  return $suggestBooks;
}

?>
