INSERT INTO equipements (nom, categorie, descriptions, coutPC, modifAttaque, modifInitiative)
VALUES ('Épée en bois', 'arme', 'Épée courte en bois, parfaite pour l\'entraînement', 18, 3, 1);

INSERT INTO equipements (nom, categorie, descriptions, coutPC, modifDefense)
VALUES ('Brigandine', 'armure', 'Armure souple en cuir clouté', 22, 4);

INSERT INTO equipements (nom, categorie, descriptions, coutPC, modifDefense, modifMouvement)
VALUES ('Écu', 'secondaire', 'Bouclier de taille moyenne', 12, 2, -1);

-- Test erreur de catégorie
INSERT INTO equipements (nom, categorie, descriptions, coutPC, modifAttaque, modifInitiative)
VALUES ('Épée en fer', 'armes', 'Épée courte en fer.', 26, 6, 1);
-- #4025 - CONSTRAINT `verification_categorie_equipement` failed for `guilde_aventurier`.`equipements`

-- Test erreur de coût en PC
INSERT INTO equipements (nom, categorie, descriptions, coutPC, modifAttaque, modifInitiative)
VALUES ('Épée en fer', 'arme', 'Épée courte en fer.', 0, 6, 1);
-- #4025 - CONSTRAINT `verification_coutPC_equipement` failed for `guilde_aventurier`.`equipements`