CREATE TABLE client
(
  login varchar(20) PRIMARY KEY NOT NULL,
  password varchar(60) NOT NULL,
  last_name VARCHAR(30) NOT NULL,
  first_name VARCHAR(30) NOT NULL,
  email_address VARCHAR(50) NOT NULL,
  age int NOT NULL CHECK (age>0),
  gender VARCHAR(1) NOT NULL CHECK (gender IN ('f', 'm')),
  country VARCHAR(50) NOT NULL,
  sp_category VARCHAR(50) NOT NULL CHECK (sp_category IN ('Agriculteurs exploitants', 'Artisans, commerçants, chefs d entreprise', 'Cadres et professions intellectuelles supérieures', 'Professions intermédiaires', 'Employés', 'Ouvriers', 'Retraités', 'Autres sans activité professionnelle')),
);

CREATE TABLE book
(
  id_book serial PRIMARY KEY NOT NULL,
  title varchar(50) NOT NULL,
  lang VARCHAR(2) NOT NULL,
  genre varchar(30),
  price NUMERIC (8,2) NOT NULL,
  release_year INT,
  score NUMERIC (6,5) NOT NULL DEFAULT 2.5,
  resume TEXT
);

CREATE TABLE author
(
  id_author serial PRIMARY KEY NOT NULL,
  last_name VARCHAR(30) NOT NULL,;
  first_name VARCHAR(30) NOT NULL,
  birth_year int NOT NULL
);

CREATE TABLE write
(
  id_author serial,
  id_book serial,
   CONSTRAINT FK_bookwrite FOREIGN KEY (id_book) REFERENCES book(id_book) ON DELETE CASCADE,
  CONSTRAINT FK_authorwrite FOREIGN KEY (id_author) REFERENCES author(id_author)
);

CREATE TABLE seen
(
  login varchar,
  id_book serial,
  sale_date date,
  CONSTRAINT FK_bookseen FOREIGN KEY (id_book) REFERENCES book(id_book) ON DELETE CASCADE,
  CONSTRAINT FK_clientseen FOREIGN KEY (login) REFERENCES client(login)
);

INSERT INTO client(login, password, last_name, first_name, email_address, age, gender, country, sp_category) VALUES ('jean1', '$2y$10$Y8oO0NfKuBEpwYb6WoMeI.UtLXxzULDC2iHbjqNrQyyEf6Wjk9sG.', 'Verre', 'Jean', 'jean.v@mail.fr', '19', 'm', 'France', 'Autres sans activité professionnelle');

INSERT INTO author(last_name, first_name, birth_year) VALUES ('Collins', 'Suzanne', '1962');

INSERT INTO client( title, lang, genre, price, release_year, resume) VALUES ('Hunger Games - Tome 1', 'fr', 'Science-fiction', '20.90', '2008', 'Peeta et Katniss sont tirés au sort pour participer aux Hunger Games. La règle est simple : 24 candidats pour un seul survivant, le tout sous le feu des caméras...\nDans un futur sombre, sur les ruines des États-Unis, un jeu télévisé est créé pour contrôler le peuple par la terreur.\nDouze garçons et douze filles tirés au sort participent à cette sinistre téléréalité, que tout le monde est forcé de regarder en direct. Une seule règle dans l\'arène : survivre, à tout prix. Quand sa petite sœur est appelée pour participer aux Hunger Games, Katniss n\'hésite pas une seconde. Elle prend sa place, consciente du danger. À seize ans, Katniss a déjà été confrontée plusieurs fois à la mort. Chez elle, survivre est comme une seconde nature...');

INSERT INTO client(title, lang, genre, price, release_year, resume) VALUES ('Hunger Games - Tome 2 : L\'embrasement', 'fr', 'Science-fiction', '20.90', '2009', 'À la fois symbole de la rébellion et marionnette d\'une dictature sanglante, Katniss a le pouvoir entre ses mains... liées.\nAprès le succès des derniers Hunger Games, le peuple de Panem est impatient de retrouver Katniss et Peeta pour la Tournée de la victoire. Mais pour Katniss, il s\'agit surtout d\'une tournée de la dernière chance. Celle qui a osé défier le Capitole est devenue le symbole d\'une rébellion qui pourrait bien embraser Panem. Si elle échoue à ramener le calme dans les districts, le président Snow n\'hésitera pas à noyer dans le sang le feu de la révolte. À l\'aube des Jeux de l\'Expiation, le piège du Capitole se referme sur Katniss...');

INSERT INTO client(title, lang, genre, price, release_year, resume) VALUES ('Hunger Games - Tome 3 : La révolte', 'fr', 'Science-fiction', '20.90', '2010', 'Je m\'appelle Katniss Everdeen. Je devrais être morte. Maintenant je vais mener la révolte.\nContre toute attente, Katniss a survécu une seconde fois aux Hunger Games. Mais le Capitole crie vengeance. Katniss doit payer les humiliations qu\'elle lui a fait subir. Et le président Snow a été très clair : Katniss n\'est pas la seule à risquer sa vie. Sa famille, ses amis et tous les anciens habitants du district Douze sont visés par la colère sanglante du pouvoir. Pour sauver les siens, Katniss doit redevenir le geai moqueur, le symbole de la rébellion. Quel que soit le prix à payer.');

INSERT INTO write(id_author, id_book) VALUES ('1', '1');

INSERT INTO write(id_author, id_book) VALUES ('1', '2');

INSERT INTO write(id_author, id_book) VALUES ('1', '3');

INSERT INTO seen(login, id_book, sale_date) VALUES ('jean1', '1', '');




