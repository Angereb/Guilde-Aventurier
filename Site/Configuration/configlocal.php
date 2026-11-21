<?php
return [
    "serveur" => getenv("DB_HOST"),
    "base" => getenv("MARIADB_DATABASE"),
    "utilisateur" => getenv("MARIADB_USER"),
    "motDePasse" => getenv("MARIADB_PASSWORD"),
    "port" => getenv("DB_PORT"),
    "serveurMongo" => getenv("MONGO_HOST"),
    "portMongo" => getenv("MONGO_PORT"),
    "utilisateurMongo" => getenv("MONGO_UTILISATEUR_SITE"),
    "motDePasseMongo" => getenv("MONGO_MOT_DE_PASSE_SITE"),
    "baseMongo" => getenv("MONGO_DATABASE"),
];


?>