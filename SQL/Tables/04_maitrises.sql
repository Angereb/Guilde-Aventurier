CREATE TABLE maitrises(

    -- Identifiant interne
    maitriseId BIGINT PRIMARY KEY AUTO_INCREMENT,

    -- Informations des maîtrises
    nom VARCHAR(64) NOT NULL UNIQUE,
    descriptions TEXT NOT NULL
        
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;