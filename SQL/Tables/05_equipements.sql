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
    modifAttaque SMALLINT NOT NULL DEFAULT 0,
    modifDefense SMALLINT NOT NULL DEFAULT 0,
    modifPV SMALLINT NOT NULL DEFAULT 0,
    modifPE SMALLINT NOT NULL DEFAULT 0,
    modifInitiative SMALLINT NOT NULL DEFAULT 0,
    modifMouvement SMALLINT NOT NULL DEFAULT 0
        
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;