<?php
// Règles d'évolution des aventuriers : modifier ici pour l'équilibrage
const REGLES = [
    "caracteristiques" => [
        "minimum" => 0,
        "depart" => 10,
        "maximum" => 100,
        "paliers" => [
            ["jusqua" => 20, "cout" => 1],
            ["jusqua" => 40, "cout" => 2],
            ["jusqua" => 60, "cout" => 3],
            ["jusqua" => 80, "cout" => 4],
            ["jusqua" => 100, "cout" => 5]
        ]
    ],
    "maitrises" => [
        "minimum" => 0,
        "depart" => 0,
        "maximum" => 500,
        "paliers" => [
            ["jusqua" => 100, "cout" => 1],
            ["jusqua" => 200, "cout" => 2],
            ["jusqua" => 275, "cout" => 3],
            ["jusqua" => 350, "cout" => 4],
            ["jusqua" => 400, "cout" => 5],
            ["jusqua" => 450, "cout" => 6],
            ["jusqua" => 500, "cout" => 7]
        ]
    ],
    "secondaires" => [
        "attaque" => ["base" => 1],
        "defense" => ["base" => 1],
        "caracteristiqueVitalite" => "Robustesse",
        "pv" => ["base" => 20, "parNiveau" => 2],
        "pe" => ["base" => 5, "niveauxParPoint" => 5],
        "initiative" => ["base" => 5],
        "mouvement" => ["base" => 6]
    ]
];
?>