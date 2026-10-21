CREATE TABLE zones_effets(

    -- Identifiant interne
    zoneEffetId BIGINT PRIMARY KEY AUTO_INCREMENT,

    -- Informations des zones d'effet
    nom VARCHAR(64) NOT NULL UNIQUE,
    directions SET('nord', 'nord-est', 'est', 'sud-est', 'sud', 'sud-ouest', 'ouest', 'nord-ouest') NOT NULL,
    portee INT NOT NULL,
    CONSTRAINT verification_portee_zone_effet CHECK (portee > 0),
    icone MEDIUMBLOB,
    typeIcone VARCHAR(32)

) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;