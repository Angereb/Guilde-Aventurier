CREATE TABLE equipements(

    -- Identifiant interne
    equipementId BIGINT PRIMARY KEY AUTO_INCREMENT,

    -- Informations des équipements
    nom VARCHAR(64) NOT NULL UNIQUE,
    categorie VARCHAR(64) NOT NULL,
    CONSTRAINT verification_categorie_equipement CHECK (categorie IN ('arme', 'secondaire', 'armure', 'bijou')),
    descriptions TEXT NOT NULL,
    coutPC INT NOT NULL,
    CONSTRAINT verification_coutPC_equipement CHECK (coutPC > 0),

    -- Modificateur de caractéristiques secondaires possible
    modifAttaque SMALLINT NULL DEFAULT NULL,
    modifDefense SMALLINT NULL DEFAULT NULL,
    modifPV SMALLINT NULL DEFAULT NULL,
    modifPE SMALLINT NULL DEFAULT NULL,
    modifInitiative SMALLINT NULL DEFAULT NULL,
    modifMouvement SMALLINT NULL DEFAULT NULL
        
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;