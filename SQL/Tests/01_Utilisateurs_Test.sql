INSERT INTO utilisateurs (uuid, pseudo, nomCompagnie, email, motDePasse, roles) 
VALUES (UUID(),'Aventurier1', 'Compagnie1', 'test.compagnie@email.com', 'motdepasse1', '["ROLE_USER", "ROLE_ADMIN"]');