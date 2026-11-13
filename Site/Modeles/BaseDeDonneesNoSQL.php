<?php
require_once __DIR__ . "/../../vendor/autoload.php";

use MongoDB\Client;
use MongoDB\Database;

class BaseDeDonneesNoSQL {
    private static string $serveurNoSql;
    private static string $baseNoSql;
    private static string $utilisateurBaseNoSql;
    private static string $motDePasseBaseNoSql;
    private static int $portNoSql;

    private static function chargerConfigurationNoSql(): void {
        $configurationNoSql = require __DIR__ . "/../Configuration/configlocal.php";
        foreach(["serveurMongo", "portMongo", "utilisateurMongo", "motDePasseMongo", "baseMongo"] as $cleNoSql) {
            if (!isset($configurationNoSql[$cleNoSql]) || $configurationNoSql[$cleNoSql] === false || $configurationNoSql[$cleNoSql] === "") {
                throw new Exception("Configuration de la base NoSQL incomplète : la valeur « $cleNoSql » est manquante.");
            }
        }
        $portNoSql = filter_var($configurationNoSql["portMongo"], FILTER_VALIDATE_INT);
        if ($portNoSql === false) {
            throw new Exception("Configuration de la base NoSQL incorrecte : le port doit être un nombre entier.");
        }
        self::$serveurNoSql = $configurationNoSql["serveurMongo"];
        self::$baseNoSql = $configurationNoSql["baseMongo"];
        self::$utilisateurBaseNoSql = $configurationNoSql["utilisateurMongo"];
        self::$motDePasseBaseNoSql = $configurationNoSql["motDePasseMongo"];
        self::$portNoSql = $portNoSql;
    }

    private static ?Database $base = null;

    public static function connexion(): Database {
        if (self::$base === null) {
            self::chargerConfigurationNoSql();
            $uri = "mongodb://"
                . rawurlencode(self::$utilisateurBaseNoSql) . ":"
                . rawurlencode(self::$motDePasseBaseNoSql) . "@"
                . self::$serveurNoSql . ":"
                . self::$portNoSql . "/?authSource=" . rawurlencode(self::$baseNoSql);
            try {
                $client = new Client($uri);
                self::$base = $client->selectDatabase(self::$baseNoSql);
            } catch (Exception $e) {
                error_log("Erreur de connexion MongoDB : " . $e->getMessage());
                throw new Exception("Impossible de se connecter à la base de données NoSQL.");
            }
        }
        return self::$base;
    }
}
?>