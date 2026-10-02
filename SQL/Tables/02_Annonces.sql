CREATE TABLE annonces(

    -- Identifiant interne
    annonceId BIGINT PRIMARY KEY AUTO_INCREMENT,

    -- Informations des annonces
    titre VARCHAR(128) NOT NULL,
    contenu TEXT NOT NULL,
    CONSTRAINT verification_contenu_annonce CHECK (contenu != ''),

    -- Informations de suivi
    publierLe DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    publierParId BIGINT NOT NULL, 
        
    FOREIGN KEY (publierParId)
        REFERENCES utilisateurs(utilisateurId)
        ON DELETE RESTRICT

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;