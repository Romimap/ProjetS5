-- -----------------------------------------------------
-- Groupe K
-- Membres :
--     - Benhammadi Youssef
--     - Fournier Romain
-- -----------------------------------------------------


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
  gps VARCHAR(50) NOT NULL,
  date_debut DATE NOT NULL,
  date_fin DATE NOT NULL,
  effectif_min INT(5) DEFAULT NULL,
  effectif_max INT(5) DEFAULT NULL,
  -- KEYS
  PRIMARY KEY (id),
  KEY k_taxonomie (id_mot_clef),
  KEY k_membre (id_membre)
  
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE inscriptions (
  id INT(11) NOT NULL UNIQUE AUTO_INCREMENT,
  id_evenement INT(11) NOT NULL,
  id_membre INT(11) NOT NULL,
  note TINYINT(4) NOT NULL DEFAULT 0,
  commentaire VARCHAR(240) DEFAULT NULL,
  -- KEYS
  PRIMARY KEY (id),
  KEY fk_membre (id_membre),
  KEY fk_evenement (id_evenement)
  
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE photos (
  id INT(11) NOT NULL UNIQUE AUTO_INCREMENT,
  id_evenement INT(11) NOT NULL,
  lien VARCHAR(240) NOT NULL,
  -- KEYS
  PRIMARY KEY (id),
  KEY fk (id_evenement)
  
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE taxonomie (
  id INT(11) NOT NULL UNIQUE AUTO_INCREMENT,
  parent INT(11) NOT NULL,
  mot VARCHAR(20) NOT NULL,
  -- KEYS
  PRIMARY KEY (id),
  KEY fk (parent)
  
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- -----------------------------------
-- ajout des clefs etrangeres
-- -----------------------------------

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