CREATE TABLE maitrises_aventuriers(

    -- Informations des liens
    maitriseId BIGINT,
    aventurierId BIGINT,

    -- Compléments des liens
    niveau SMALLINT NOT NULL,
    CONSTRAINT verification_niveau_maitrises_aventuriers CHECK (niveau >= 0),

    -- Clés
    PRIMARY KEY (maitriseId, aventurierId),
    FOREIGN KEY (maitriseId)
        REFERENCES maitrises(maitriseId)
        ON DELETE CASCADE,
    FOREIGN KEY (aventurierId)
        REFERENCES aventuriers(aventurierId)
        ON DELETE CASCADE
        
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;