CREATE TABLE utilisateurs (
    
    -- Identifiant interne
    id BIGINT PRIMARY KEY AUTO_INCREMENT,

    -- UUID publique
    uuid CHAR(36) NOT NULL UNIQUE,

    -- Informations de base
    pseudo VARCHAR(64) NOT NULL UNIQUE,
    nomCompagnie VARCHAR(128) NOT NULL,
    email VARCHAR(128) NOT NULL UNIQUE,

    -- Informations de sécurité
    motDePasse VARCHAR(255) NOT NULL,

    -- Authorisations
    roles JSON NOT NULL,

    -- Informations de suivi
    creerLe DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modifierLe DATETIME NULL DEFAULT NULL
);