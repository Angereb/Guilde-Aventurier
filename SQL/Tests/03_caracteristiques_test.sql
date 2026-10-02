INSERT INTO caracteristiques (nom, descriptions)
VALUES ('Force', 'Caractéristique musculaire d\'un aventurier.');

INSERT INTO caracteristiques (nom, descriptions)
VALUES ('Robustesse', 'Caractéristique de la capacité d\'un aventurier à être robuste.');

INSERT INTO caracteristiques (nom, descriptions)
VALUES ('Esprit', 'Caractéristique d\'un aventurier pour l\'utilisation de ses sens et de sa réflexion.');

INSERT INTO caracteristiques (nom, descriptions)
VALUES ('Agilité', 'Caractéristique d\'un aventurier pour les jeux d\'adresse et son habileté de mouvement.');

-- Test doublon de nom
INSERT INTO caracteristiques (nom, descriptions)
VALUES ('Force', 'Caractéristique d\'un aventurier à employé ses muscles.');
-- #1062 - Duplicata du champ 'Force' pour la clef 'nom'