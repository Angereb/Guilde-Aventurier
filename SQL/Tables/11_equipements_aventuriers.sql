CREATE TABLE equipements_aventuriers(

    -- Informations des liens
    equipementId BIGINT,
    aventurierId BIGINT,

    -- Compléments des liens
    quantite SMALLINT NOT NULL,
    CONSTRAINT verification_quantite_equipements_aventuriers CHECK (quantite > 0),
    etat VARCHAR(32) NOT NULL,
    CONSTRAINT verification_etat_equipements_aventuriers CHECK (etat IN ('equipe', 'inventaire')),

    -- Clés
    PRIMARY KEY (equipementId, aventurierId),
    FOREIGN KEY (equipementId)
        REFERENCES equipements(equipementId)
        ON DELETE CASCADE,
    FOREIGN KEY (aventurierId)
        REFERENCES aventuriers(aventurierId)
        ON DELETE CASCADE
        
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;