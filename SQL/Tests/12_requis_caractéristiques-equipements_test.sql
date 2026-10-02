INSERT INTO requis_caracteristiques_equipements (caracteristiqueId, equipementId, valeur)
VALUES (1, 1, 10);

-- Test erreur d'id de caractéristique
INSERT INTO requis_caracteristiques_equipements (caracteristiqueId, equipementId, valeur)
VALUES (898, 1, 15);
-- #1452 - Cannot add or update a child row: a foreign key constraint fails (`guilde_aventurier`.`requis_caracteristiques_equipements`, CONSTRAINT `requis_caracteristiques_equipements_ibfk_1` FOREIGN KEY (`caracteristiqueId`) REFERENCES `caracteristiques` (`caracteristique)

-- Test erreur d'id d'équipement
INSERT INTO requis_caracteristiques_equipements (caracteristiqueId, equipementId, valeur)
VALUES (2, 999, 15);
-- #1452 - Cannot add or update a child row: a foreign key constraint fails (`guilde_aventurier`.`requis_caracteristiques_equipements`, CONSTRAINT `requis_caracteristiques_equipements_ibfk_2` FOREIGN KEY (`equipementId`) REFERENCES `equipements` (`equipementId`) ON DELETE )

-- Test erreur de valeur
INSERT INTO requis_caracteristiques_equipements (caracteristiqueId, equipementId, valeur)
VALUES (2, 1, -2);
-- #4025 - CONSTRAINT `verification_valeur_requis_caracteristiques_equipements` failed for `guilde_aventurier`.`requis_caracteristiques_equipements`