CREATE TABLE competences_aventuriers(

    -- Informations des liens
    competenceId BIGINT,
    aventurierId BIGINT,

    -- Clés
    PRIMARY KEY (competenceId, aventurierId),
    FOREIGN KEY (competenceId)
        REFERENCES competences(competenceId)
        ON DELETE CASCADE,
    FOREIGN KEY (aventurierId)
        REFERENCES aventuriers(aventurierId)
        ON DELETE CASCADE
        
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;