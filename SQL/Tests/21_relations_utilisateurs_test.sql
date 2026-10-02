INSERT INTO relations_utilisateurs (utilisateurId, contactId, statut)
VALUES (1, 2, 'Ami');

-- Test erreur d'id d'utilisateur
INSERT INTO relations_utilisateurs (utilisateurId, contactId, statut)
VALUES (785, 2, 'Bloqué');
-- #1452 - Cannot add or update a child row: a foreign key constraint fails (`guilde_aventurier`.`relations_utilisateurs`, CONSTRAINT `relations_utilisateurs_ibfk_1` FOREIGN KEY (`utilisateurId`) REFERENCES `utilisateurs` (`utilisateurId`) ON DELETE CASCADE)

-- Test erreur d'id de contact
INSERT INTO relations_utilisateurs (utilisateurId, contactId, statut)
VALUES (2, 785, 'Ami');
-- #1452 - Cannot add or update a child row: a foreign key constraint fails (`guilde_aventurier`.`relations_utilisateurs`, CONSTRAINT `relations_utilisateurs_ibfk_2` FOREIGN KEY (`contactId`) REFERENCES `utilisateurs` (`utilisateurId`) ON DELETE CASCADE)

-- Test erreur de relation vers soi-même
INSERT INTO relations_utilisateurs(utilisateurId, contactId, statut)
VALUES (2, 2, 'Ami');
-- #4025 - CONSTRAINT `verification_difference_utilisateur` failed for `guilde_aventurier`.`relations_utilisateurs`