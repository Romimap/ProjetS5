-- -----------------------------------------------------
-- Groupe K
-- Membres :
--     - Benhammadi Youssef
--     - Fournier Romain
-- -----------------------------------------------------

-- reset
DROP DATABASE IF EXISTS ProjetBddGroupeK;
CREATE DATABASE IF NOT EXISTS ProjetBddGroupeK;
-- use
USE ProjetBddGroupeK;

-- -----------------------------------------------------
-- Création des tables et des contraintes
-- -----------------------------------------------------

CREATE TABLE evenement (
  id INT(11) NOT NULL UNIQUE AUTO_INCREMENT,
  id_mot_clef INT(11) NOT NULL,
  id_membre INT(11) NOT NULL,
  nom VARCHAR(50) NOT NULL,
  description VARCHAR(240) NOT NULL,
  addresse VARCHAR(50) NOT NULL,
  date_debut DATE NOT NULL,
  date_fin DATE NOT NULL,
  effectif_min INT(5) DEFAULT NULL,
  effectif_max INT(5) DEFAULT NULL,
  etat VARCHAR(10) DEFAULT 'Normal',
  -- KEYS
  PRIMARY KEY (id),
  KEY k_taxonomie (id_mot_clef),
  KEY k_membre (id_membre),
  -- CONSTRAINTS
  CONSTRAINT etat_check CHECK (etat IN ('Normal', 'Annule'))

) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE inscriptions (
  id INT(11) NOT NULL UNIQUE AUTO_INCREMENT,
  id_evenement INT(11) NOT NULL,
  id_membre INT(11) NOT NULL,
  note TINYINT(4) NOT NULL DEFAULT 0,
  commentaire VARCHAR(240) DEFAULT NULL,
  -- KEYS
  PRIMARY KEY (id),
  KEY k_membre (id_membre),
  KEY k_evenement (id_evenement)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE membres (
  id INT(11) NOT NULL UNIQUE AUTO_INCREMENT,
  username VARCHAR(20) NOT NULL,
  password VARCHAR(128) NOT NULL,
  nom VARCHAR(20) DEFAULT NULL,
  prenom VARCHAR(20) DEFAULT NULL,
  email VARCHAR(50) NOT NULL,
  ville VARCHAR(20) DEFAULT NULL,
  adresse VARCHAR(100) DEFAULT NULL,
  telephone VARCHAR(10) DEFAULT NULL,
  role VARCHAR(20) NOT NULL DEFAULT 'Visiteur',
  ban DATE DEFAULT NULL,
  -- KEYS
  PRIMARY KEY (id),
  -- CONSTRAINTS
  CONSTRAINT role_check CHECK (role IN ('Visiteur', 'Contributeur', 'Admin')),
  CONSTRAINT email_check CHECK (email LIKE '%@%')

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE photos (
  id INT(11) NOT NULL UNIQUE AUTO_INCREMENT,
  id_evenement INT(11) NOT NULL,
  lien VARCHAR(240) NOT NULL,
  -- KEYS
  PRIMARY KEY (id),
  KEY k (id_evenement)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE taxonomie (
  id INT(11) NOT NULL UNIQUE AUTO_INCREMENT,
  parent INT(11) NOT NULL,
  mot VARCHAR(20) NOT NULL,
  -- KEYS
  PRIMARY KEY (id),
  KEY k (parent)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- -----------------------------------------------------
-- ajout des clefs étrangères
-- -----------------------------------------------------

ALTER TABLE evenement
  ADD CONSTRAINT fk_evenement_membre FOREIGN KEY (id_membre) REFERENCES membres (id),
  ADD CONSTRAINT fk_evenement_taxonomie FOREIGN KEY (id_mot_clef) REFERENCES taxonomie (id);

ALTER TABLE inscriptions
  ADD CONSTRAINT fk_inscription_evenement FOREIGN KEY (id_evenement) REFERENCES evenement (id),
  ADD CONSTRAINT fk_inscription_membre FOREIGN KEY (id_membre) REFERENCES membres (id);

ALTER TABLE photos
  ADD CONSTRAINT fk_photos_evenement FOREIGN KEY (id_evenement) REFERENCES evenement (id);

ALTER TABLE taxonomie
  ADD CONSTRAINT fk_taxonomie_taxonomie FOREIGN KEY (parent) REFERENCES taxonomie (id);

-- -----------------------------------------------------
-- insertions par défaut
-- -----------------------------------------------------

SET FOREIGN_KEY_CHECKS = 0;

-- compte admin par défaut, (le mot de passe devrait etre salté et hashé, il est laissé comme tel par soucis de lisibilité)
INSERT INTO membres (username, password, email, role) VALUES
('adminuser', 'pass', 'admin@email.fr', 'admin');

-- racine de l'arbre des themes
INSERT INTO taxonomie (id, parent, mot) VALUES (0, -1, 'Général');
UPDATE taxonomie SET id = 0, parent = -1 WHERE mot = 'Général';

SET FOREIGN_KEY_CHECKS = 1;

-- -----------------------------------------------------
-- triggers
-- -----------------------------------------------------

DELIMITER |

CREATE TRIGGER t_bi_evenement BEFORE INSERT ON evenement FOR EACH ROW
BEGIN
  DECLARE m_tmp_effectif INT(10);
  DECLARE m_tmp_date DATE;

  IF NEW.effectif_min > NEW.effectif_max
    THEN
    SET m_tmp_effectif = NEW.effectif_min;
    SET NEW.effectif_min = NEW.effectif_max;
    SET NEW.effectif_max = m_tmp_effectif;
  END IF;
  IF UNIX_TIMESTAMP(NEW.date_debut) > UNIX_TIMESTAMP(NEW.date_fin)
    THEN
    SET m_tmp_date = NEW.date_fin;
    SET NEW.date_fin = NEW.date_debut;
    SET NEW.date_debut = m_tmp_date;
  END IF;
END |

CREATE TRIGGER t_bu_inscriptions BEFORE UPDATE ON inscriptions FOR EACH ROW
BEGIN
  IF NEW.id_membre != OLD.id_membre
    THEN
    SET NEW.id_membre = OLD.id_membre;
  END IF;
  IF NEW.id_evenement != OLD.id_evenement
    THEN
    SET NEW.id_evenement = OLD.id_evenement;
  END IF;
  IF NEW.note < 1
    THEN
    SET NEW.note = 1;
  ELSEIF NEW.note > 5
    THEN
    SET NEW.note = 5;
  END IF;
END |

CREATE TRIGGER t_bi_inscriptions BEFORE INSERT ON inscriptions FOR EACH ROW
BEGIN
  IF NEW.id_membre IN (SELECT id_membre FROM inscriptions WHERE id_evenement = NEW.id_evenement)
    THEN
    SIGNAL SQLSTATE VALUE '45000' SET MESSAGE_TEXT ="MEMBRE DEJA INSCRIT";
  END IF;
  IF (SELECT COUNT(*) FROM inscriptions WHERE id_evenement = NEW.id_evenement) >= (SELECT effectif_max FROM evenement WHERE id = NEW.id_evenement)
    THEN
    SIGNAL SQLSTATE VALUE '45001' SET MESSAGE_TEXT ="TROP DE MEMBRES DEJA INSCRIT";
  END IF;
END |

DELIMITER ;

-- -----------------------------------------------------
-- procédures
-- -----------------------------------------------------



-- -----------------------------------------------------
-- insertions
-- par soucis de simplicité, certains champs seront laissés comme NULL, et les mot de passes ne seront pas hashés
-- -----------------------------------------------------

-- MEMBRES
INSERT INTO membres (username, password, nom, prenom, email) VALUES
('jdupont01', 'pass', 'Dupont', 'Jean', 'jean.dupont@email.fr'),
('fred1995', 'pass', 'Leon', 'Frederic', 'fred.leon@email.fr'),
('billybill', 'pass', 'Bill', 'Billy', 'billy2000@email.fr'),
('gandalfthegray', 'pass', 'Mithrandir', 'Gray', 'gandalf@maiar.fr'),
('shadowfax', 'pass', 'Shadow', 'Fax', 'shadowfax@horse.fr');
-- définition d'un Contributeur
UPDATE membres SET role = 'Contributeur' WHERE username = 'gandalfthegray';

-- TAXONOMIE
INSERT INTO taxonomie (id, parent, mot) VALUES
(2, 0, 'sport'),
(3, 0, 'musique');
INSERT INTO taxonomie (id, parent, mot) VALUES
(4, 2, 'football'),
(5, 2, 'tenis'),
(6, 3, 'concert'),
(7, 3, 'festival');

-- EVENEMENT
INSERT INTO evenement (id_mot_clef, id_membre, nom, description, addresse, date_debut, date_fin, effectif_min, effectif_max) VALUES
(4, 4, 'match de foot', 'un match de foot', 'stade de france', '2020-01-01', '2020-01-05', '100', '1000'),
(6, 4, 'concert de rock', 'un concert de rock', 'comedie, montpellier', '2020-02-01', '2020-02-01', '0', '2');

-- PHOTOS
INSERT INTO photos (id_evenement, lien) VALUES
(1, 'imageFoot.png'),
(1, 'imageFoot2.gif'),
(2, 'imageRock.jpg');

-- INSCPTIONS
INSERT INTO inscriptions (id_evenement, id_membre) VALUES
(1, 1),
(1, 2),
(1, 3);
