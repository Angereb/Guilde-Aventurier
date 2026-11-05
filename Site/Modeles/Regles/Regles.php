<?php
require_once __DIR__ . "/../../Configuration/regles.php";

class Regles {
    // Coût total d'une valeur : la somme du coût de chaque niveau, de 1 jusqu'à la valeur
    private static function coutValeur(int $valeur, array $paliers): int {
        $cout = 0;
        for ($niveau = 1; $niveau <= $valeur; $niveau++) {
            foreach ($paliers as $palier) {
                if ($niveau <= $palier["jusqua"]) {
                    $cout += $palier["cout"];
                    break;
                }
            }
        }
        return $cout;
    }

    public static function coutCaracteristique(int $valeur): int {
        return self::coutValeur($valeur, REGLES["caracteristiques"]["paliers"]);
    }

    public static function coutMaitrise(int $valeur): int {
        return self::coutValeur($valeur, REGLES["maitrises"]["paliers"]);
    }

    public static function calculerPV(int $robustesse): int {
        return REGLES["secondaires"]["pv"]["base"] + $robustesse * REGLES["secondaires"]["pv"]["parNiveau"];
    }

    public static function calculerPE(int $robustesse): int {
        return REGLES["secondaires"]["pe"]["base"] + intdiv($robustesse, REGLES["secondaires"]["pe"]["niveauxParPoint"]);
    }
}
?>