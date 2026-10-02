CREATE TABLE requis_maitrises_equipements(

    -- Informations des liens
    maitriseId BIGINT,
    equipementId BIGINT,

    -- Compléments des liens
    valeur SMALLINT NOT NULL,
    CONSTRAINT verification_valeur_requis_maitrises_equipements CHECK (valeur > 0),

    -- Clés
    PRIMARY KEY (maitriseId, equipementId),
    FOREIGN KEY (maitriseId)
        REFERENCES maitrises(maitriseId)
        ON DELETE CASCADE,
    FOREIGN KEY (equipementId)
        REFERENCES equipements(equipementId)
        ON DELETE CASCADE
        
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;