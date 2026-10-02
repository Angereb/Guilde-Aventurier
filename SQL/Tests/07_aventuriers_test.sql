INSERT INTO aventuriers (nom, creerParId)
VALUES ('Albert', 1);

-- Test d'id utilisateurs inexistant
INSERT INTO aventuriers (nom, creerParId)
VALUES ('Gérard', 985);
-- #1452 - Cannot add or update a child row: a foreign key constraint fails (`guilde_aventurier`.`aventuriers`, CONSTRAINT `aventuriers_ibfk_1` FOREIGN KEY (`creerParId`) REFERENCES `utilisateurs` (`utilisateurId`) ON DELETE CASCADE)