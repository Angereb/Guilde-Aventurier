CREATE TABLE requis_caracteristiques_competences(

    -- Informations des liens
    caracteristiqueId BIGINT,
    competenceId BIGINT,

    -- Compléments des liens
    valeur SMALLINT NOT NULL,
    CONSTRAINT verification_valeur_requis_caracteristiques_competences CHECK (valeur > 0),

    -- Clés
    PRIMARY KEY (caracteristiqueId, competenceId),
    FOREIGN KEY (caracteristiqueId)
        REFERENCES caracteristiques(caracteristiqueId)
        ON DELETE RESTRICT,
    FOREIGN KEY (competenceId)
        REFERENCES competences(competenceId)
        ON DELETE CASCADE
        
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;