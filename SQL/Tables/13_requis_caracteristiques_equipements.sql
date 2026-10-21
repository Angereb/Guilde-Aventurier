CREATE TABLE requis_caracteristiques_equipements(

    -- Informations des liens
    caracteristiqueId BIGINT,
    equipementId BIGINT,

    -- Compléments des liens
    valeur SMALLINT NOT NULL,
    CONSTRAINT verification_valeur_requis_caracteristiques_equipements CHECK (valeur > 0),

    -- Clés
    PRIMARY KEY (caracteristiqueId, equipementId),
    FOREIGN KEY (caracteristiqueId)
        REFERENCES caracteristiques(caracteristiqueId)
        ON DELETE RESTRICT,
    FOREIGN KEY (equipementId)
        REFERENCES equipements(equipementId)
        ON DELETE CASCADE
        
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;