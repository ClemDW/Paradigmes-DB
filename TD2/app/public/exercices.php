<?php
/**
 * Created by PhpStorm.
 * User: canals5
 * Date: 28/10/2019
 * Time: 16:16
 */

use MongoDB\Client;

require_once __DIR__ . "/../vendor/autoload.php";

$client = new Client("mongodb://mongo:27017");
$dataBase = $client->chopizza;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>ChoPizza - Exercices</title>
</head>
<body>
    <nav>
        <a href="index.php">Catalogue</a> | 
        <a href="add_product.php">Ajouter un produit</a> | 
        <a href="exercices.php"><b>Réponses TD</b></a>
    </nav>
<?php
echo "<h3>Question 1</h3><br>";
echo "Nombre de produit : " . $dataBase->produit->countDocuments() . "<br><br>";
$produits = $dataBase->produit->find( [],
        ['projection' =>
        [ "numero"=>1,
        "categorie"=>1,
        "libelle"=>1]
        ]);

foreach ($produits as $produit) {
    echo "Numero : " . $produit['numero'] . "<br>";
    echo "Categorie : " . $produit['categorie'] . "<br>";
    echo "Libelle : " . $produit['libelle'] . "<br><br>";
}

echo "<h3>Question 2</h3><br>";
$produits = $dataBase->produit->find( [
        "numero"=>6
    ],
    ['projection' =>
        [ "numero"=>1,
            "categorie"=>1,
            "libelle"=>1,
            "description"=>1,
            "tarifs"=>1
        ]
    ]);

foreach ($produits as $produit) {
    echo "Numero : " . $produit['numero'] . "<br>";
    echo "Categorie : " . $produit['categorie'] . "<br>";
    echo "Libelle : " . $produit['libelle'] . "<br>";
    echo "Description : " . $produit['description'] . "<br>";
    echo "Tarifs :<br>";
    foreach ($produit['tarifs'] as $tarif) {
        echo "-Taille : " . $tarif['taille'] .
            " | Tarif : " . $tarif['tarif'] . " €<br>";
    }
    echo "<br>";
}

echo "<h3>Question 3</h3><br>";
$produits = $dataBase->produit->find( [
        'tarifs' => [
            '$elemMatch' => [
                'taille' => 'normale',
                'tarif'  => ['$lte' => 3.0]
            ]
        ]
    ],
    ['projection' =>
        [ "numero"=>1,
            "categorie"=>1,
            "libelle"=>1,
            "description"=>1,
            "tarifs"=>1
        ]
    ]);

foreach ($produits as $produit) {
    echo "Numero : " . $produit['numero'] . "<br>";
    echo "Categorie : " . $produit['categorie'] . "<br>";
    echo "Libelle : " . $produit['libelle'] . "<br>";
    echo "Description : " . $produit['description'] . "<br>";
    echo "Tarifs :<br>";
    foreach ($produit['tarifs'] as $tarif) {
        echo "-Taille : " . $tarif['taille'] .
            " | Tarif : " . $tarif['tarif'] . " €<br>";
    }
    echo "<br>";
}

echo "<h3>Question 4</h3><br>";
$produits = $dataBase->produit->find( [
    'recettes' => [
        '$size' => 4,
    ]
],
    ['projection' =>
        [ "numero"=>1,
            "categorie"=>1,
            "libelle"=>1,
            "description"=>1,
            "tarifs"=>1
        ]
    ]);

foreach ($produits as $produit) {
    echo "Numero : " . $produit['numero'] . "<br>";
    echo "Categorie : " . $produit['categorie'] . "<br>";
    echo "Libelle : " . $produit['libelle'] . "<br>";
    echo "Description : " . $produit['description'] . "<br>";
    echo "Tarifs :<br>";
    foreach ($produit['tarifs'] as $tarif) {
        echo "-Taille : " . $tarif['taille'] .
            " | Tarif : " . $tarif['tarif'] . " €<br>";
    }
    echo "<br>";
}

echo "<h3>Question 5</h3><br>";
$produit = $dataBase->produit->findOne(['numero' => 6]);
foreach ([$produit] as $produit) { // Keep the loop structure if preferred, but single fetch is enough
    echo "Numero : " . $produit['numero'] . "<br>";
    echo "Categorie : " . $produit['categorie'] . "<br>";
    echo "Libelle : " . $produit['libelle'] . "<br>";
    echo "Description : " . $produit['description'] . "<br>";
    echo "Tarifs :<br>";
    foreach ($produit['tarifs'] as $tarif) {
        echo "-Taille : " . $tarif['taille'] .
            " | Tarif : " . $tarif['tarif'] . " €<br>";
    }
    echo "<br>";
}

$recettesIds = $produit['recettes']->getArrayCopy();
$recettes = $dataBase->recettes->find(
    ['_id' => ['$in' => $recettesIds]],
    ['projection' => [
            "nom"=>1,
            "difficulte"=>1
        ]
    ]
);
echo "Recettes :<br>";
foreach ($recettes as $recette) {
    echo "- " . $recette['nom'] . " difficulté : " . $recette['difficulte'] . "<br>";
}



echo "<h3>Question 6</h3><br>";
function getProduitByNumeroEtTaille($dataBase, $numero, $taille) {
    $p = $dataBase->produit->findOne(['numero'=>$numero]);
    foreach ($p['tarifs'] as $t) {
        if ($t['taille'] == $taille) {
            return [
                'numero'=>$p['numero'],
                'libelle'=>$p['libelle'],
                'categorie'=>$p['categorie'],
                'taille'=>$taille,
                'tarif'=>$t['tarif']
            ];
        }
    }
}
echo json_encode(getProduitByNumeroEtTaille($dataBase, 5, 'normale'));
?>
</body>
</html>