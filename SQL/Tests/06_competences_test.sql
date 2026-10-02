INSERT INTO competences (nom, descriptions, types, coutPE, modifAttaque)
VALUES ('Abattage', 'Coup brutal descendant avec une épée à une main', 'active', 5, 10);

INSERT INTO competences (nom, descriptions, types, coutPE, modifPV)
VALUES ('Rigueur', 'La rigueur martiale vous a rendu plus résistant à la douleur', 'passive', 0, 5);

-- Test erreur de type
INSERT INTO competences (nom, descriptions, types, coutPE)
VALUES ('Fauchage', 'Balayage avec une épée à une main', 'actives', 5);
-- #4025 - CONSTRAINT `verification_type_competence` failed for `guilde_aventurier`.`competences`

-- Test erreur de coût par rapport au type
INSERT INTO competences (nom, descriptions, types, coutPE)
VALUES ('Fauchage', 'Balayage avec une épée à une main', 'active', 0);
-- #4025 - CONSTRAINT `verification_coutPE_competence` failed for `guilde_aventurier`.`competences`