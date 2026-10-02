CREATE TABLE caracteristiques(

    -- Identifiant interne
    caracteristiqueId BIGINT PRIMARY KEY AUTO_INCREMENT,

    -- Informations des caractéristiques
    nom VARCHAR(32) NOT NULL UNIQUE,
    descriptions TEXT NOT NULL
        
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;