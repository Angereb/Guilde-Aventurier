CREATE TABLE relations_utilisateurs(

    -- Informations des liens
    utilisateurId BIGINT,
    contactId BIGINT,
    CONSTRAINT verification_difference_utilisateur CHECK (utilisateurId != contactId),

    -- Compléments des liens
    creerLe DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    statut VARCHAR(32) NOT NULL,

    -- Clés
    PRIMARY KEY (utilisateurId, contactId),
    FOREIGN KEY (utilisateurId)
        REFERENCES utilisateurs(utilisateurId)
        ON DELETE CASCADE,
    FOREIGN KEY (contactId)
        REFERENCES utilisateurs(utilisateurId)
        ON DELETE CASCADE
        
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;