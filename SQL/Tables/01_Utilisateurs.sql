CREATE TABLE utilisateurs (
    
    -- Identifiant interne
    utilisateurId BIGINT PRIMARY KEY AUTO_INCREMENT,

    -- UUID public
    uuid CHAR(36) NOT NULL UNIQUE,

    -- Informations de base
    pseudo VARCHAR(64) NOT NULL UNIQUE,
    nomCompagnie VARCHAR(128) NOT NULL,
    email VARCHAR(128) NOT NULL UNIQUE,

    -- Informations de sécurité
    motDePasse VARCHAR(255) NOT NULL,

    -- Autorisations
    roles JSON NOT NULL,

    -- Informations de suivi
    creerLe DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    modifierLe DATETIME NULL DEFAULT NULL,
    estSupprime BOOLEAN NOT NULL DEFAULT FALSE,
    actif BOOLEAN NOT NULL DEFAULT TRUE
    
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;