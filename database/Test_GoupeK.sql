/*
FIchier : Test_GroupeK.sql
Auteurs :
Romain FOURNIER 21814031
Youssef BENHAMMADI 21807967
Nom du groupe : K
*/

-- -----------------------------------------------------
-- t_bi_evenement
-- -----------------------------------------------------

SELECT '---------- TEST t_bi_evenement ----------' AS '';

INSERT INTO evenement (id_mot_clef, id_membre, nom, description, addresse, date_debut, date_fin, effectif_min, effectif_max) VALUES
(4, 4, 'date inversée', '', '', '2022-02-02', '2020-01-01', '0', '0'),
(4, 4, 'effectif inversé', '', '', '2020-01-01', '2020-01-01', '15', '5'),
(4, 4, 'tout inversé', '', '', '2022-02-02', '2020-01-01', '15', '5');

SELECT nom, date_debut, date_fin, effectif_min, effectif_max FROM evenement
WHERE nom IN ('date inversée', 'effectif inversé', 'tout inversé');

-- -----------------------------------------------------
-- t_bu_inscriptions
-- -----------------------------------------------------

SELECT '---------- TEST t_bu_inscriptions ----------' AS '';
SELECT '--- avant update' AS '';

SELECT membres.id AS user_id, username, evenement.nom AS nom_event, note FROM membres, evenement, inscriptions
WHERE membres.id = inscriptions.id_membre AND evenement.id = inscriptions.id_evenement
AND inscriptions.id_membre IN (2, 3, 4);

UPDATE inscriptions SET note = 0 WHERE id_membre = 2;
UPDATE inscriptions SET note = 9 WHERE id_membre = 3;
UPDATE inscriptions SET id_membre = 20, id_evenement = 20 WHERE id_membre = 4;

SELECT '--- apres update' AS '';

SELECT membres.id AS user_id, username, evenement.nom AS nom_event, note FROM membres, evenement, inscriptions
WHERE membres.id = inscriptions.id_membre AND evenement.id = inscriptions.id_evenement
AND inscriptions.id_membre IN (2, 3, 4);

-- -----------------------------------------------------
-- t_bi_inscriptions
-- -----------------------------------------------------

SELECT '---------- TEST t_bi_inscriptions ----------' AS '';
SELECT '--- avant insert' AS '';

SELECT membres.id AS user_id, username, evenement.nom AS nom_event FROM membres, evenement, inscriptions
WHERE membres.id = inscriptions.id_membre AND evenement.id = inscriptions.id_evenement
AND inscriptions.id_evenement = 2;

INSERT INTO inscriptions (id_evenement, id_membre) VALUES (2, 2);
-- INSERT INTO inscriptions (id_evenement, id_membre) VALUES (2, 2); -- décommentez cette ligne pour generer l'erreur "MEMBRE DEJA INSCRIT"
INSERT INTO inscriptions (id_evenement, id_membre) VALUES (2, 3);
-- INSERT INTO inscriptions (id_evenement, id_membre) VALUES (2, 4); -- décommentez cette ligne pour generer l'erreur "TROP DE MEMBRES DEJA INSCRIT"
SELECT '--- apres insert' AS '';

SELECT membres.id AS user_id, username, evenement.nom AS nom_event FROM membres, evenement, inscriptions
WHERE membres.id = inscriptions.id_membre AND evenement.id = inscriptions.id_evenement
AND inscriptions.id_evenement = 2;

-- -----------------------------------------------------
-- p_duree_evenement
-- -----------------------------------------------------

SELECT '---------- TEST p_duree_evenement ----------' AS '';
CALL p_duree_evenement(1);
CALL p_duree_evenement(2);

-- -----------------------------------------------------
-- p_inscription_count
-- -----------------------------------------------------

SELECT '---------- TEST p_inscription_count ----------' AS '';
CALL p_inscription_count(1);
CALL p_inscription_count(2);

-- -----------------------------------------------------
-- p_is_admin
-- -----------------------------------------------------

SELECT '---------- TEST p_is_admin ----------' AS '';
CALL p_is_admin(1);
CALL p_is_admin(2);
CALL p_is_admin(3);
CALL p_is_admin(4);
CALL p_is_admin(5);

-- -----------------------------------------------------
-- p_is_contributeur
-- -----------------------------------------------------

SELECT '---------- TEST p_is_contributeur ----------' AS '';
CALL p_is_contributeur(1);
CALL p_is_contributeur(2);
CALL p_is_contributeur(3);
CALL p_is_contributeur(4);
CALL p_is_contributeur(5);
