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
    modifAttaque SMALLINT NOT NULL DEFAULT 0,
    modifDefense SMALLINT NOT NULL DEFAULT 0,
    modifPV SMALLINT NOT NULL DEFAULT 0,
    modifPE SMALLINT NOT NULL DEFAULT 0,
    modifInitiative SMALLINT NOT NULL DEFAULT 0,
    modifMouvement SMALLINT NOT NULL DEFAULT 0
        
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;