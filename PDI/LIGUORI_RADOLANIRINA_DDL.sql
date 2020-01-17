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
  id_client serial,
  id_book serial,
  sale_date date,
  CONSTRAINT FK_bookseen FOREIGN KEY (id_book) REFERENCES book(id_book) ON DELETE CASCADE,
  CONSTRAINT FK_clientseen FOREIGN KEY (id_client) REFERENCES client(id_client)
);

INSERT INTO client(first_name, last_name, email_address, password_client, credit, admin) VALUES ('Jean', 'Verre', 'j-verr@lolo.fr', '$2y$10$Y8oO0NfKuBEpwYb6WoMeI.UtLXxzULDC2iHbjqNrQyyEf6Wjk9sG.', '999.00', '0');


