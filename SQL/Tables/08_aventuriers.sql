CREATE TABLE aventuriers(

    -- Identifiant interne
    aventurierId BIGINT PRIMARY KEY AUTO_INCREMENT,

    -- Informations des aventuriers
    nom VARCHAR(64) NOT NULL,
    icone MEDIUMBLOB,
    typeIcone VARCHAR(32),

    -- Informations de suivi
    creerLe DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modifierLe DATETIME NULL DEFAULT NULL,
    creerParId BIGINT NOT NULL, 
        
    FOREIGN KEY (creerParId)
        REFERENCES utilisateurs(utilisateurId)
        ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;