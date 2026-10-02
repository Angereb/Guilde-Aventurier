INSERT INTO utilisateurs (uuid, pseudo, nomCompagnie, email, motDePasse, roles) 
VALUES (UUID(),'Aventurier1', 'Compagnie1', 'test.compagnie@email.com', 'motdepasse1', '["ROLE_UTILISATEUR", "ROLE_ADMIN"]');

-- Test doublon de pseudo
INSERT INTO utilisateurs (uuid, pseudo, nomCompagnie, email, motDePasse, roles) 
VALUES (UUID(),'Aventurier1', 'Compagnie2', 'test.compagnie2@email.com', 'motdepasse2', '["ROLE_UTILISATEUR"]');
-- #1062 - Duplicata du champ 'Aventurier1' pour la clef 'pseudo'

-- Test doublon d'email
INSERT INTO utilisateurs (uuid, pseudo, nomCompagnie, email, motDePasse, roles) 
VALUES (UUID(),'Aventurier2', 'Compagnie3', 'test.compagnie@email.com', 'motdepasse3', '["ROLE_UTILISATEUR"]');
-- #1062 - Duplicata du champ 'test.compagnie@email.com' pour la clef 'email'

-- Ajout d'un utilisateur pour test des relations
INSERT INTO utilisateurs (uuid, pseudo, nomCompagnie, email, motDePasse, roles) 
VALUES (UUID(),'Aventurier2', 'Compagnie2', 'test.compagnie2@email.com', 'motdepasse2', '["ROLE_UTILISATEUR"]');