CREATE TABLE annonces(

    -- Idenfiant interne
    id BIGINT PRIMARY KEY AUTO_INCREMENT,

    -- Informations des annonces
    titre VARCHAR(128) NOT NULL,
    contenu TEXT NOT NULL,

    -- Informations de suivi
    publierLe DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    creerParId BIGINT NOT NULL, 
        
    FOREIGN KEY (creerParId)
        REFERENCES utilisateurs(id) 
        ON DELETE CASCADE
);