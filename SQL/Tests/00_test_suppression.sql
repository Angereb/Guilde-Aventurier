-- Test de suppression d'une caractéristique utilisée
-- #1451 - Cannot delete or update a parent row: a foreign key constraint fails (`guilde_aventurier`.`caracteristiquesaventuriers`, CONSTRAINT `caracteristiquesaventuriers_ibfk_1` FOREIGN KEY (`caracteristiqueId`) REFERENCES `caracteristiques` (`caracteristiqueId`))

-- Test de suppression d'une maitrise utilisée
-- Réussi les liaisons ont disparus

-- Test de suppression d'un utilisateur ayant publié une annonce
-- #1451 - Cannot delete or update a parent row: a foreign key constraint fails (`guilde_aventurier`.`annonces`, CONSTRAINT `annonces_ibfk_1` FOREIGN KEY (`publierParId`) REFERENCES `utilisateurs` (`utilisateurId`))

-- test de suppression d'un aventurier ayant des caractéristiques, des maitrises, des équipements et des compétences
-- Réussi toutes les liaisons ont disparus