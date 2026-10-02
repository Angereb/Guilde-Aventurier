INSERT INTO maitrises (nom, descriptions)
VALUES ('Épée à une main', 'Permet l\'utilisation d\'épée courte, d\'épée bâtarde, de glaive, de cimeterre ou de katana.');

INSERT INTO maitrises (nom, descriptions)
VALUES ('Épée à deux mains', 'Permet l\'utilisation d\'épée longue, d\'espadon, de sabre mamelouk ou de nodachi.');

INSERT INTO maitrises (nom, descriptions)
VALUES ('Lance', 'Permet l\'utilisation de lance, de javelot, de bardiche, d\'hallebarde ou de yari.');

INSERT INTO maitrises (nom, descriptions)
VALUES ('Arc', 'Permet l\'utilisation de l\'arc court, de l\'arc courbe ou de l\'arc long.');

-- Test doublon de nom
INSERT INTO maitrises (nom, descriptions)
VALUES ('Arc', 'Permet l\'utilisation de l\'arc court, de l\'arc courbe ou de l\'arc long.');
-- #1062 - Duplicata du champ 'Arc' pour la clef 'nom'