INSERT INTO deblocage_competences_utilisateurs (competenceId, utilisateurId)
VALUES (1, 1);

-- Test erreur d'id de compétences
INSERT INTO deblocage_competences_utilisateurs (competenceId, utilisateurId)
VALUES (785, 1);
-- #1452 - Cannot add or update a child row: a foreign key constraint fails (`guilde_aventurier`.`deblocage_competences_utilisateurs`, CONSTRAINT `deblocage_competences_utilisateurs_ibfk_1` FOREIGN KEY (`competenceId`) REFERENCES `competences` (`competenceId`) ON DELETE CA)

-- Test erreur d'id d'utilisateur
INSERT INTO deblocage_competences_utilisateurs (competenceId, utilisateurId)
VALUES (1, 865);
-- #1452 - Cannot add or update a child row: a foreign key constraint fails (`guilde_aventurier`.`deblocage_competences_utilisateurs`, CONSTRAINT `deblocage_competences_utilisateurs_ibfk_2` FOREIGN KEY (`utilisateurId`) REFERENCES `utilisateurs` (`utilisateurId`) ON DELETE)