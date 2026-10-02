INSERT INTO caracteristiques_aventuriers (caracteristiqueId, aventurierId, niveau)
VALUES (1, 1, 10);

-- Test erreur d'id de caractéristique
INSERT INTO caracteristiques_aventuriers (caracteristiqueId, aventurierId, niveau)
VALUES (989, 1, 15);
-- #1452 - Cannot add or update a child row: a foreign key constraint fails (`guilde_aventurier`.`caracteristiques_aventuriers`, CONSTRAINT `caracteristiques_aventuriers_ibfk_1` FOREIGN KEY (`caracteristiqueId`) REFERENCES `caracteristiques` (`caracteristiqueId`))

-- Test erreur d'id d'aventurier
INSERT INTO caracteristiques_aventuriers (caracteristiqueId, aventurierId, niveau)
VALUES (2, 999, 15);
-- #1452 - Cannot add or update a child row: a foreign key constraint fails (`guilde_aventurier`.`caracteristiques_aventuriers`, CONSTRAINT `caracteristiques_aventuriers_ibfk_2` FOREIGN KEY (`aventurierId`) REFERENCES `aventuriers` (`aventurierId`) ON DELETE CASCADE)

-- Test erreur de niveau
INSERT INTO caracteristiques_aventuriers (caracteristiqueId, aventurierId, niveau)
VALUES (2, 1, -2);
-- #4025 - CONSTRAINT `verification_niveau_caracteristiques_aventuriers` failed for `guilde_aventurier`.`caracteristiques_aventuriers`

-- Test erreur de doublon de lien
INSERT INTO caracteristiques_aventuriers (caracteristiqueId, aventurierId, niveau)
VALUES (1, 1, 10);
-- #1062 - Duplicata du champ '1-1' pour la clef 'PRIMARY'