<?php
class BaseDeDonnees {
    private static string $serveur;
    private static string $base;
    private static string $utilisateurBase;
    private static string $motDePasseBase;

    /*Chargement des paramètres de connexion depuis le fichier configuration */
    private static function chargerConfiguration() : void {
        $configuration = require __DIR__ . "/../Configuration/configuration.php";

        self::$serveur = $configuration["serveur"];
        self::$base = $configuration["base"];
        self::$utilisateurBase = $configuration["utilisateur"];
        self::$motDePasseBase = $configuration["motDePasse"];
    }

    private static ?PDO $pdo = null;

    public static function connexion() : PDO {
        if (self::$pdo === null){
            self::chargerConfiguration();

            $dsn = "mysql:host=" . self::$serveur .
            ";dbname=" . self::$base .
            ";charset=utf8mb4";

            self::$pdo = new PDO(
                $dsn,
                self::$utilisateurBase,
                self::$motDePasseBase
            );

            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$pdo;
    }
        
}
?>