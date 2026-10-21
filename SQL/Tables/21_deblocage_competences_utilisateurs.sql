CREATE TABLE deblocage_competences_utilisateurs(

    -- Informations des liens
    competenceId BIGINT,
    utilisateurId BIGINT,

    -- Clés
    PRIMARY KEY (competenceId, utilisateurId),
    FOREIGN KEY (competenceId)
        REFERENCES competences(competenceId)
        ON DELETE CASCADE,
    FOREIGN KEY (utilisateurId)
        REFERENCES utilisateurs(utilisateurId)
        ON DELETE CASCADE
        
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;