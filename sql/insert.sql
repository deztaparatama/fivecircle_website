SET datestyle TO european;

-- users(id, pseudo, password, mail, name, surname, date_birth, photo_name, status, created)
INSERT INTO users VALUES(DEFAULT, 'ben', '24c77611993f4b5ce8751ee71f8d433acd61f673', 'benoit.gros.93@gmail.com', 'Gros', 'Benoit', '8/12/1993', DEFAULT, DEFAULT, DEFAULT);
INSERT INTO users VALUES(DEFAULT, 'chapa', '24c77611993f4b5ce8751ee71f8d433acd61f673', 'mickael.bourgier@gmail.com', 'Bourgier', 'Mickael', '8/12/1994', '2.jpeg', DEFAULT, DEFAULT);
INSERT INTO users VALUES(DEFAULT, 'skorp', '24c77611993f4b5ce8751ee71f8d433acd61f673', 'vincentdimper@gmail.com', 'Dimper', 'Vincent', '8/12/1993', DEFAULT, DEFAULT, DEFAULT);
INSERT INTO users VALUES(DEFAULT, 'KonRan', '24c77611993f4b5ce8751ee71f8d433acd61f673', 'timothe.bournay@gmail.com', 'Bournay', 'Timothe', '8/12/1993', DEFAULT, DEFAULT, DEFAULT);
INSERT INTO users VALUES(DEFAULT, 'elunywow', '24c77611993f4b5ce8751ee71f8d433acd61f673', 'elunywow@gmail.com', 'Pinto', 'Alexandre', '8/12/1993', DEFAULT, DEFAULT, DEFAULT);

-- friends(id, user_id, friend_id, created)
INSERT INTO friends VALUES(DEFAULT, 1, 2, DEFAULT);
INSERT INTO friends VALUES(DEFAULT, 1, 3, DEFAULT);
INSERT INTO friends VALUES(DEFAULT, 1, 4, DEFAULT);
INSERT INTO friends VALUES(DEFAULT, 2, 1, DEFAULT);
INSERT INTO friends VALUES(DEFAULT, 2, 3, DEFAULT);
INSERT INTO friends VALUES(DEFAULT, 3, 1, DEFAULT);

-- places(id, name, photo_name, latitude, longitude)
INSERT INTO places VALUES(DEFAULT, 'IUT2', 'IUT_2_-_Grenoble.JPG', 45.192026, 5.717327);
INSERT INTO places VALUES(DEFAULT, 'Gare de Grenoble', 'signaletique-gare-grenoble-1.jpg', 45.191512, 5.714414);
INSERT INTO places VALUES(DEFAULT, 'Eglise du sacre coeur', 'sacre_coeur.jpg', 45.191755, 5.716313);
INSERT INTO places VALUES(DEFAULT, 'Le 17eme', '111212_pola17e1.jpg', 45.189905, 5.71576);
INSERT INTO places VALUES(DEFAULT, 'Le Rabot', '23772881.jpg', 45.195833, 5.723656);

-- visited(id, user_id, place_id, created)
INSERT INTO visited VALUES(DEFAULT, 2, 5, '01/09/2011 13:23:12');
INSERT INTO visited VALUES(DEFAULT, 5, 1, '10/09/2012 12:23:12');
INSERT INTO visited VALUES(DEFAULT, 1, 1, '01/09/2011 11:23:12');
INSERT INTO visited VALUES(DEFAULT, 2, 1, '01/09/2011 10:23:12');
INSERT INTO visited VALUES(DEFAULT, 3, 1, '01/09/2011 19:23:12');
INSERT INTO visited VALUES(DEFAULT, 4, 1, '01/09/2011 18:23:12');
INSERT INTO visited VALUES(DEFAULT, 1, 4, '17/03/2012 17:23:12');
INSERT INTO visited VALUES(DEFAULT, 1, 2, '03/09/2012 16:23:12');
INSERT INTO visited VALUES(DEFAULT, 2, 2, '31/08/2012 15:23:12');
INSERT INTO visited VALUES(DEFAULT, 3, 2, '31/08/2012 14:23:12');
INSERT INTO visited VALUES(DEFAULT, 5, 2, '09/09/2012 09:23:12');
INSERT INTO visited VALUES(DEFAULT, 4, 4, '17/03/2012 08:23:12');
INSERT INTO visited VALUES(DEFAULT, 1, 3, '01/09/2011 11:24:12');

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
