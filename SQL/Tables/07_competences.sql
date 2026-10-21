CREATE TABLE competences(

    -- Identifiant interne
    competenceId BIGINT PRIMARY KEY AUTO_INCREMENT,

    -- Informations des compétences
    nom VARCHAR(64) NOT NULL UNIQUE,
    descriptions TEXT NOT NULL,
    types VARCHAR(32) NOT NULL,
    CONSTRAINT verification_type_competence CHECK (types IN ('active', 'passive')),
    coutPE INT NOT NULL DEFAULT 0,
    CONSTRAINT verification_coutPE_competence CHECK ((types = 'active' AND coutPE > 0) OR (types = 'passive' AND coutPE = 0)),

    -- Modificateur de caractéristiques secondaires possible
    modifAttaque SMALLINT NULL DEFAULT NULL,
    modifDefense SMALLINT NULL DEFAULT NULL,
    modifPV SMALLINT NULL DEFAULT NULL,
    modifPE SMALLINT NULL DEFAULT NULL,
    modifInitiative SMALLINT NULL DEFAULT NULL,
    modifMouvement SMALLINT NULL DEFAULT NULL,

    -- Clé étrangère vers la zone d'effet pour les compétences actives
    zoneEffetId BIGINT,
    CONSTRAINT verification_zoneEffetId_competence CHECK ((types = 'active' AND zoneEffetId IS NOT NULL) OR (types = 'passive' AND zoneEffetId IS null)),
    FOREIGN KEY (zoneEffetId)
        REFERENCES zones_effets(zoneEffetId)
        ON DELETE RESTRICT
        
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;