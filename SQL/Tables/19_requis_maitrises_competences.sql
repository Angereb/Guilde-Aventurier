CREATE TABLE requis_maitrises_competences(

    -- Informations des liens
    maitriseId BIGINT,
    competenceId BIGINT,

    -- Compléments des liens
    valeur SMALLINT NOT NULL,
    CONSTRAINT verification_valeur_requis_maitrises_competences CHECK (valeur > 0),

    -- Clés
    PRIMARY KEY (maitriseId, competenceId),
    FOREIGN KEY (maitriseId)
        REFERENCES maitrises(maitriseId)
        ON DELETE CASCADE,
    FOREIGN KEY (competenceId)
        REFERENCES competences(competenceId)
        ON DELETE CASCADE
        
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;