INSERT INTO annonces (titre, contenu, publierParId)
VALUES ('Annonce 1', 'Test d\'une annonce', 1);

-- Test d'id utilisateur inexistant
INSERT INTO annonces (titre, contenu, publierParId)
VALUES ('Annonce 2', 'Test d\'une annonce', 985);
-- #1452 - Cannot add or update a child row: a foreign key constraint fails (`guilde_aventurier`.`annonces`, CONSTRAINT `annonces_ibfk_1` FOREIGN KEY (`publierParId`) REFERENCES `utilisateurs` (`utilisateurId`))

-- Test oublie du contenu
INSERT INTO annonces (titre, publierParId)
VALUES ('Annonce 3', 1);
-- Passe car le serveur a pour sql_mode le mode 'non strict' et non en mode 'strict', mais est rempli par ''. -> ajout d\'un check
-- Après ajout du check  #4025 - CONSTRAINT `verification_contenu_annonce` failed for `guilde_aventurier`.`annonces`