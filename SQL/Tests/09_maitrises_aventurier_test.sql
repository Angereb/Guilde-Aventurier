INSERT INTO maitrises_aventuriers (maitriseId, aventurierId, niveau)
VALUES (1, 1, 10);

-- Test erreur d'id de maîtrise
INSERT INTO maitrises_aventuriers  (maitriseId, aventurierId, niveau)
VALUES (898, 1, 15);
-- #1452 - Cannot add or update a child row: a foreign key constraint fails (`guilde_aventurier`.`maitrises_aventuriers `, CONSTRAINT `maitrises_aventuriers _ibfk_1` FOREIGN KEY (`maitriseId`) REFERENCES `maitrises` (`maitriseId`) ON DELETE CASCADE)

-- Test erreur d'id d'aventurier
INSERT INTO maitrises_aventuriers  (maitriseId, aventurierId, niveau)
VALUES (2, 999, 15);
-- #1452 - Cannot add or update a child row: a foreign key constraint fails (`guilde_aventurier`.`maitrises_aventuriers `, CONSTRAINT `maitrises_aventuriers _ibfk_2` FOREIGN KEY (`aventurierId`) REFERENCES `aventuriers` (`aventurierId`) ON DELETE CASCADE)

-- Test erreur de niveau
INSERT INTO maitrises_aventuriers  (maitriseId, aventurierId, niveau)
VALUES (2, 1, -2);
-- #4025 - CONSTRAINT `verification_niveau_maitrises_aventuriers` failed for `guilde_aventurier`.`maitrises_aventuriers `