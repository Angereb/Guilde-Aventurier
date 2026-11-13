CREATE DATABASE IF NOT EXISTS guilde_aventurier
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE guilde_aventurier;

CREATE TABLE utilisateurs (
    utilisateurId BIGINT PRIMARY KEY AUTO_INCREMENT,
    uuid CHAR(36) NOT NULL UNIQUE,
    pseudo VARCHAR(64) NOT NULL UNIQUE,
    nomCompagnie VARCHAR(128) NOT NULL,
    email VARCHAR(128) NOT NULL UNIQUE,
    motDePasse VARCHAR(255) NOT NULL,
    roles JSON NOT NULL,
    creerLe DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modifierLe DATETIME NULL DEFAULT NULL,
    estSupprime BOOLEAN NOT NULL DEFAULT FALSE,
    actif BOOLEAN NOT NULL DEFAULT TRUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE annonces(
    annonceId BIGINT PRIMARY KEY AUTO_INCREMENT,
    titre VARCHAR(128) NOT NULL,
    contenu TEXT NOT NULL,
    CONSTRAINT verification_contenu_annonce CHECK (contenu != ''),
    publierLe DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    publierParId BIGINT NOT NULL, 
    FOREIGN KEY (publierParId)
        REFERENCES utilisateurs(utilisateurId)
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE caracteristiques(
    caracteristiqueId BIGINT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(32) NOT NULL UNIQUE,
    descriptions TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE maitrises(
    maitriseId BIGINT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(64) NOT NULL UNIQUE,
    descriptions TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE equipements(
    equipementId BIGINT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(64) NOT NULL UNIQUE,
    categorie VARCHAR(64) NOT NULL,
    CONSTRAINT verification_categorie_equipement CHECK (categorie IN ('arme', 'secondaire', 'armure', 'bijou')),
    descriptions TEXT NOT NULL,
    coutPC INT NOT NULL,
    CONSTRAINT verification_coutPC_equipement CHECK (coutPC > 0),
    modifAttaque SMALLINT NULL DEFAULT NULL,
    modifDefense SMALLINT NULL DEFAULT NULL,
    modifPV SMALLINT NULL DEFAULT NULL,
    modifPE SMALLINT NULL DEFAULT NULL,
    modifInitiative SMALLINT NULL DEFAULT NULL,
    modifMouvement SMALLINT NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE zones_effets(
    zoneEffetId BIGINT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(64) NOT NULL UNIQUE,
    directions SET('nord', 'nord-est', 'est', 'sud-est', 'sud', 'sud-ouest', 'ouest', 'nord-ouest') NOT NULL,
    portee INT NOT NULL,
    CONSTRAINT verification_portee_zone_effet CHECK (portee > 0),
    icone MEDIUMBLOB,
    typeIcone VARCHAR(32)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE competences(
    competenceId BIGINT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(64) NOT NULL UNIQUE,
    descriptions TEXT NOT NULL,
    types VARCHAR(32) NOT NULL,
    CONSTRAINT verification_type_competence CHECK (types IN ('active', 'passive')),
    coutPE INT NOT NULL DEFAULT 0,
    CONSTRAINT verification_coutPE_competence CHECK ((types = 'active' AND coutPE > 0) OR (types = 'passive' AND coutPE = 0)),
    modifAttaque SMALLINT NULL DEFAULT NULL,
    modifDefense SMALLINT NULL DEFAULT NULL,
    modifPV SMALLINT NULL DEFAULT NULL,
    modifPE SMALLINT NULL DEFAULT NULL,
    modifInitiative SMALLINT NULL DEFAULT NULL,
    modifMouvement SMALLINT NULL DEFAULT NULL,
    zoneEffetId BIGINT,
    CONSTRAINT verification_zoneEffetId_competence CHECK ((types = 'active' AND zoneEffetId IS NOT NULL) OR (types = 'passive' AND zoneEffetId IS null)),
    FOREIGN KEY (zoneEffetId)
        REFERENCES zones_effets(zoneEffetId)
        ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE aventuriers(
    aventurierId BIGINT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(64) NOT NULL,
    icone MEDIUMBLOB,
    typeIcone VARCHAR(32),
    creerLe DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modifierLe DATETIME NULL DEFAULT NULL,
    creerParId BIGINT NOT NULL, 
    FOREIGN KEY (creerParId)
        REFERENCES utilisateurs(utilisateurId)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE caracteristiques_aventuriers(
    caracteristiqueId BIGINT,
    aventurierId BIGINT,
    niveau SMALLINT NOT NULL,
    CONSTRAINT verification_niveau_caracteristiques_aventuriers CHECK (niveau >= 0),
    PRIMARY KEY (caracteristiqueId, aventurierId),
    FOREIGN KEY (caracteristiqueId)
        REFERENCES caracteristiques(caracteristiqueId)
        ON DELETE RESTRICT,
    FOREIGN KEY (aventurierId)
        REFERENCES aventuriers(aventurierId)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE maitrises_aventuriers(
    maitriseId BIGINT,
    aventurierId BIGINT,
    niveau SMALLINT NOT NULL,
    CONSTRAINT verification_niveau_maitrises_aventuriers CHECK (niveau >= 0),
    PRIMARY KEY (maitriseId, aventurierId),
    FOREIGN KEY (maitriseId)
        REFERENCES maitrises(maitriseId)
        ON DELETE CASCADE,
    FOREIGN KEY (aventurierId)
        REFERENCES aventuriers(aventurierId)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE equipements_aventuriers(
    equipementId BIGINT,
    aventurierId BIGINT,
    quantite SMALLINT NOT NULL,
    CONSTRAINT verification_quantite_equipements_aventuriers CHECK (quantite > 0),
    etat VARCHAR(32) NOT NULL,
    CONSTRAINT verification_etat_equipements_aventuriers CHECK (etat IN ('equipe', 'inventaire')),
    PRIMARY KEY (equipementId, aventurierId),
    FOREIGN KEY (equipementId)
        REFERENCES equipements(equipementId)
        ON DELETE CASCADE,
    FOREIGN KEY (aventurierId)
        REFERENCES aventuriers(aventurierId)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE competences_aventuriers(
    competenceId BIGINT,
    aventurierId BIGINT,
    PRIMARY KEY (competenceId, aventurierId),
    FOREIGN KEY (competenceId)
        REFERENCES competences(competenceId)
        ON DELETE CASCADE,
    FOREIGN KEY (aventurierId)
        REFERENCES aventuriers(aventurierId)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE requis_caracteristiques_equipements(
    caracteristiqueId BIGINT,
    equipementId BIGINT,
    valeur SMALLINT NOT NULL,
    CONSTRAINT verification_valeur_requis_caracteristiques_equipements CHECK (valeur > 0),
    PRIMARY KEY (caracteristiqueId, equipementId),
    FOREIGN KEY (caracteristiqueId)
        REFERENCES caracteristiques(caracteristiqueId)
        ON DELETE RESTRICT,
    FOREIGN KEY (equipementId)
        REFERENCES equipements(equipementId)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE modif_caracteristiques_equipements(
    caracteristiqueId BIGINT,
    equipementId BIGINT,
    valeur SMALLINT NOT NULL,
    CONSTRAINT verification_valeur_modif_caracteristiques_equipements CHECK (valeur <> 0),
    PRIMARY KEY (caracteristiqueId, equipementId),
    FOREIGN KEY (caracteristiqueId)
        REFERENCES caracteristiques(caracteristiqueId)
        ON DELETE RESTRICT,
    FOREIGN KEY (equipementId)
        REFERENCES equipements(equipementId)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE requis_maitrises_equipements(
    maitriseId BIGINT,
    equipementId BIGINT,
    valeur SMALLINT NOT NULL,
    CONSTRAINT verification_valeur_requis_maitrises_equipements CHECK (valeur > 0),
    PRIMARY KEY (maitriseId, equipementId),
    FOREIGN KEY (maitriseId)
        REFERENCES maitrises(maitriseId)
        ON DELETE CASCADE,
    FOREIGN KEY (equipementId)
        REFERENCES equipements(equipementId)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE modif_maitrises_equipements(
    maitriseId BIGINT,
    equipementId BIGINT,
    valeur SMALLINT NOT NULL,
    CONSTRAINT verification_valeur_modif_maitrises_equipements CHECK (valeur <> 0),
    PRIMARY KEY (maitriseId, equipementId),
    FOREIGN KEY (maitriseId)
        REFERENCES maitrises(maitriseId)
        ON DELETE CASCADE,
    FOREIGN KEY (equipementId)
        REFERENCES equipements(equipementId)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE requis_caracteristiques_competences(
    caracteristiqueId BIGINT,
    competenceId BIGINT,
    valeur SMALLINT NOT NULL,
    CONSTRAINT verification_valeur_requis_caracteristiques_competences CHECK (valeur > 0),
    PRIMARY KEY (caracteristiqueId, competenceId),
    FOREIGN KEY (caracteristiqueId)
        REFERENCES caracteristiques(caracteristiqueId)
        ON DELETE RESTRICT,
    FOREIGN KEY (competenceId)
        REFERENCES competences(competenceId)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE modif_caracteristiques_competences(
    caracteristiqueId BIGINT,
    competenceId BIGINT,
    valeur SMALLINT NOT NULL,
    CONSTRAINT verification_valeur_modif_caracteristiques_competences CHECK (valeur <> 0),
    PRIMARY KEY (caracteristiqueId, competenceId),
    FOREIGN KEY (caracteristiqueId)
        REFERENCES caracteristiques(caracteristiqueId)
        ON DELETE RESTRICT,
    FOREIGN KEY (competenceId)
        REFERENCES competences(competenceId)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE requis_maitrises_competences(
    maitriseId BIGINT,
    competenceId BIGINT,
    valeur SMALLINT NOT NULL,
    CONSTRAINT verification_valeur_requis_maitrises_competences CHECK (valeur > 0),
    PRIMARY KEY (maitriseId, competenceId),
    FOREIGN KEY (maitriseId)
        REFERENCES maitrises(maitriseId)
        ON DELETE CASCADE,
    FOREIGN KEY (competenceId)
        REFERENCES competences(competenceId)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE modif_maitrises_competences(
    maitriseId BIGINT,
    competenceId BIGINT,
    valeur SMALLINT NOT NULL,
    CONSTRAINT verification_valeur_modif_maitrises_competences CHECK (valeur <> 0),
    PRIMARY KEY (maitriseId, competenceId),
    FOREIGN KEY (maitriseId)
        REFERENCES maitrises(maitriseId)
        ON DELETE CASCADE,
    FOREIGN KEY (competenceId)
        REFERENCES competences(competenceId)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE deblocage_competences_utilisateurs(
    competenceId BIGINT,
    utilisateurId BIGINT,
    PRIMARY KEY (competenceId, utilisateurId),
    FOREIGN KEY (competenceId)
        REFERENCES competences(competenceId)
        ON DELETE CASCADE,
    FOREIGN KEY (utilisateurId)
        REFERENCES utilisateurs(utilisateurId)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE relations_utilisateurs(
    utilisateurId BIGINT,
    contactId BIGINT,
    CONSTRAINT verification_difference_utilisateur CHECK (utilisateurId != contactId),
    creerLe DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    statut VARCHAR(32) NOT NULL,
    CONSTRAINT verification_statut_relation CHECK (statut IN ('ami', 'rival', 'bloque', 'en_attente')),
    PRIMARY KEY (utilisateurId, contactId),
    FOREIGN KEY (utilisateurId)
        REFERENCES utilisateurs(utilisateurId)
        ON DELETE CASCADE,
    FOREIGN KEY (contactId)
        REFERENCES utilisateurs(utilisateurId)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO caracteristiques (nom, descriptions)
VALUES ('Force', 'Caractéristique musculaire d\'un aventurier.');

INSERT INTO caracteristiques (nom, descriptions)
VALUES ('Robustesse', 'Caractéristique de la capacité d\'un aventurier à être robuste.');

INSERT INTO caracteristiques (nom, descriptions)
VALUES ('Esprit', 'Caractéristique d\'un aventurier pour l\'utilisation de ses sens et de sa réflexion.');

INSERT INTO caracteristiques (nom, descriptions)
VALUES ('Agilité', 'Caractéristique d\'un aventurier pour les jeux d\'adresse et son habileté de mouvement.');