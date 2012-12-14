SET datestyle TO european;

-- users(id, pass, mail, name, surname, date_birth, created)
INSERT INTO users VALUES(DEFAULT, 'password', 'benoit.gros.93@gmail.com', 'Gros', 'Benoit', '8/12/2012', '01/01/2012'/*je laisserai pas l'ocasion a tim de savoir ma date de naissance*/);
INSERT INTO users VALUES(DEFAULT, 'password', 'mickael.bourgier@gmail.com', 'Bourgier', 'Mikckaël', '8/12/2012', '01/01/2012');
INSERT INTO users VALUES(DEFAULT, 'password', 'vincentdimper@gmail.com', 'Dimper', 'Vincent', '8/12/2012', '01/01/2012');
INSERT INTO users VALUES(DEFAULT, 'password', 'timothe.bournay@gmail.com', 'Bournay', 'Timothe', '8/12/2012', '01/01/2012');
INSERT INTO users VALUES(DEFAULT, 'password', 'elunywow@gmail.com', 'Pinto', 'Alexandre', '8/12/2012', '01/01/2012');

-- places(id, name, photo_name, latitude, longitude)
INSERT INTO places VALUES(DEFAULT, 'IUT2', 'IUT_2_-_Grenoble.JPG', 45.192026, 5.717327);
INSERT INTO places VALUES(DEFAULT, 'Gare de Grenoble', 'signaletique-gare-grenoble-1.jpg', 45.191512, 5.714414);
INSERT INTO places VALUES(DEFAULT, 'Mairie de Grenoble', 'La_Ville_de_Grenoble_cherche_des_b_n_voles.jpg', 45.186642, 5.736241);
INSERT INTO places VALUES(DEFAULT, 'Le 17eme', '111212_pola17e1.jpg', 45.189905, 5.71576);
INSERT INTO places VALUES(DEFAULT, 'Le Rabot', '23772881.jpg', 45.195833, 5.723656);

-- visited(id, user_id, place_id, created)
INSERT INTO visited VALUES(DEFAULT, 2, 5, '01/09/2011');
INSERT INTO visited VALUES(DEFAULT, 5, 1, '10/09/2012');
INSERT INTO visited VALUES(DEFAULT, 1, 1, '01/09/2011');
INSERT INTO visited VALUES(DEFAULT, 2, 1, '01/09/2011');
INSERT INTO visited VALUES(DEFAULT, 3, 1, '01/09/2011');
INSERT INTO visited VALUES(DEFAULT, 4, 1, '01/09/2011');
INSERT INTO visited VALUES(DEFAULT, 1, 4, '17/03/2012');
INSERT INTO visited VALUES(DEFAULT, 1, 2, '03/09/2012');
INSERT INTO visited VALUES(DEFAULT, 2, 2, '31/08/2012');
INSERT INTO visited VALUES(DEFAULT, 3, 2, '31/08/2012');
INSERT INTO visited VALUES(DEFAULT, 5, 2, '09/09/2012');
INSERT INTO visited VALUES(DEFAULT, 4, 4, '17/03/2012');

-- marks(id, user_id, place_id, mark)
INSERT INTO marks VALUES(DEFAULT, 1, 1, 0);
INSERT INTO marks VALUES(DEFAULT, 1, 4, 5);
INSERT INTO marks VALUES(DEFAULT, 2, 1, 3);
INSERT INTO marks VALUES(DEFAULT, 3, 1, 2);
INSERT INTO marks VALUES(DEFAULT, 4, 1, 3);
INSERT INTO marks VALUES(DEFAULT, 2, 5, 4);
INSERT INTO marks VALUES(DEFAULT, 4, 4, 5);

-- place_comments(id, user_id, place_id, content)
INSERT INTO place_comments VALUES(DEFAULT, 1, 4, 'Et une Binch, une!!!');
INSERT INTO place_comments VALUES(DEFAULT, 1, 1, 'Un lieu de torture permant');
INSERT INTO place_comments VALUES(DEFAULT, 2, 5, 'Ma maison');

-- comment_likes(id, user_id, place_comment_id)
INSERT INTO comment_likes VALUES(DEFAULT, 1, 2);
INSERT INTO comment_likes VALUES(DEFAULT, 2, 2);
INSERT INTO comment_likes VALUES(DEFAULT, 4, 1);
INSERT INTO comment_likes VALUES(DEFAULT, 4, 1);