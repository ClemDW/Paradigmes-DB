<?php
use MongoDB\Client;
require_once __DIR__ . "/../vendor/autoload.php";

$client = new Client("mongodb://mongo:27017");
$db = $client->chopizza;

$categories = $db->produit->distinct('categorie');
$activeCat = $_GET['category'] ?? ($categories[0] ?? null);

$products = $activeCat ? $db->produit->find(['categorie' => $activeCat]) : [];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>ChoPizza - Catalogue</title>
</head>
<body>
    <nav>
        <div class="menu-main">
            <a href="index.php"><b>Catalogue</b></a> | 
            <a href="add_product.php">Ajouter un produit</a> | 
            <a href="exercices.php">Réponses TD</a>
        </div>
        <hr>
        <strong>Catégories :</strong>
        <?php foreach ($categories as $cat): ?>
            <a href="index.php?category=<?= urlencode($cat) ?>"><?= $cat ?></a> |
        <?php endforeach; ?>
    </nav>

    <h1><?= htmlspecialchars($activeCat) ?></h1>

    <?php foreach ($products as $p): ?>
        <div class="product-card">
            <strong>#<?= $p['numero'] ?> - <?= htmlspecialchars($p['libelle']) ?></strong>
            <p><?= htmlspecialchars($p['description'] ?? '') ?></p>
            <ul>
                <?php foreach ($p['tarifs'] as $t): ?>
                    <li>Taille <?= $t['taille'] ?> : <span class="price"><?= $t['tarif'] ?> €</span></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endforeach; ?>
    <hr>
    <a href="exercices.php">Voir les réponses aux exercices précédents</a>
</body>
</html>
