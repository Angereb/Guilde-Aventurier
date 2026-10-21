CREATE TABLE caracteristiques_aventuriers(

    -- Informations des liens
    caracteristiqueId BIGINT,
    aventurierId BIGINT,

    -- Compléments des liens
    niveau SMALLINT NOT NULL,
    CONSTRAINT verification_niveau_caracteristiques_aventuriers CHECK (niveau >= 0),

    -- Clés
    PRIMARY KEY (caracteristiqueId, aventurierId),
    FOREIGN KEY (caracteristiqueId)
        REFERENCES caracteristiques(caracteristiqueId)
        ON DELETE RESTRICT,
    FOREIGN KEY (aventurierId)
        REFERENCES aventuriers(aventurierId)
        ON DELETE CASCADE
        
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;