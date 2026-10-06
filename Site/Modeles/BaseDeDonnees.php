<?php
class BaseDeDonnees {
    private static string $serveur;
    private static string $base;
    private static string $utilisateurBase;
    private static string $motDePasseBase;
    private static int $port;

    /*Chargement des paramètres de connexion depuis le fichier configuration */
    private static function chargerConfiguration() : void {
        $configuration = require __DIR__ . "/../Configuration/configlocal.php";
        foreach (["serveur", "base", "utilisateur", "motDePasse", "port"] as $cle) {
            if (!isset($configuration[$cle]) || $configuration[$cle] === false || $configuration[$cle] === "") {
                throw new Exception("Configuration de la base incomplète : la valeur « $cle » est manquante.");
            }
        }
        $port = filter_var($configuration["port"], FILTER_VALIDATE_INT);
        if ($port === false) {
            throw new Exception("Configuration de la base incorrecte : le port doit être un nombre entier.");
        }
        self::$serveur = $configuration["serveur"];
        self::$base = $configuration["base"];
        self::$utilisateurBase = $configuration["utilisateur"];
        self::$motDePasseBase = $configuration["motDePasse"];
        self::$port = $port;
    }

    private static ?PDO $pdo = null;

    public static function connexion() : PDO {
        if (self::$pdo === null){
            self::chargerConfiguration();
            $dsn = "mysql:host=" . self::$serveur .
            ";port=" . self::$port .
            ";dbname=" . self::$base .
            ";charset=utf8mb4";
            try {
                self::$pdo = new PDO(
                    $dsn,
                    self::$utilisateurBase,
                    self::$motDePasseBase
                );
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } 
            catch (PDOException $erreur) {
                error_log("Erreur de connexion BDD : " . $erreur->getMessage());
                throw new Exception("Le service est temporairement indisponible. Merci de réessayer plus tard.");
            } 
        }
        return self::$pdo;
    }    
}
?>