<?php
use MongoDB\Client;

require_once __DIR__ . "/../vendor/autoload.php";

$client = new Client("mongodb://mongo:27017");
$db = $client->chopizza;

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = (int)$_POST['numero'];
    $libelle = $_POST['libelle'];
    $categorie = $_POST['categorie'];
    $description = $_POST['description'];
    
    $tarifs = [];
    foreach ($_POST['taille'] as $index => $taille) {
        if (!empty($taille) && !empty($_POST['tarif'][$index])) {
            $tarifs[] = [
                'taille' => $taille,
                'tarif' => (float)$_POST['tarif'][$index]
            ];
        }
    }

    try {
        $db->produit->insertOne([
            'numero' => $numero,
            'libelle' => $libelle,
            'categorie' => $categorie,
            'description' => $description,
            'tarifs' => $tarifs
        ]);
        $message = "Produit ajouté avec succès !";
    } catch (Exception $e) {
        $message = "Erreur : " . $e->getMessage();
    }
}

$categories = $db->produit->distinct('categorie');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChoPizza - Ajouter un produit</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <nav>
        <a href="index.php">Catalogue</a> | 
        <a href="add_product.php"><b>Ajouter un produit</b></a> | 
        <a href="exercices.php">Réponses TD</a>
    </nav>

    <main>
        <header>
            <h2 style="font-size: 2rem;">Ajouter un nouveau produit</h2>
        </header>

        <div class="form-container">
            <?php if ($message): ?>
                <div style="padding: 1rem; margin-bottom: 2rem; border-radius: 10px; background: <?= str_contains($message, 'succès') ? '#d4edda' : '#f8d7da' ?>; color: <?= str_contains($message, 'succès') ? '#155724' : '#721c24' ?>;">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <form action="add_product.php" method="POST">
                <div class="form-group">
                    <label for="numero">Numéro du produit</label>
                    <input type="number" name="numero" id="numero" required>
                </div>

                <div class="form-group">
                    <label for="libelle">Libellé</label>
                    <input type="text" name="libelle" id="libelle" required>
                </div>

                <div class="form-group">
                    <label for="categorie">Catégorie</label>
                    <select name="categorie" id="categorie" required>
                        <option value="">Sélectionnez une catégorie...</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></option>
                        <?php endforeach; ?>
                        <option value="Autre">Nouvelle catégorie...</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="3"></textarea>
                </div>

                <div id="prices-container">
                    <label style="display: block; margin-bottom: 1rem; font-weight: 600;">Tarifs</label>
                    <div class="price-input" style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                        <input type="text" name="taille[]" placeholder="Taille (ex: normale)" required style="flex: 1;">
                        <input type="number" step="0.01" name="tarif[]" placeholder="Tarif (€)" required style="flex: 1;">
                    </div>
                    <div class="price-input" style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                        <input type="text" name="taille[]" placeholder="Taille (ex: grande)" style="flex: 1;">
                        <input type="number" step="0.01" name="tarif[]" placeholder="Tarif (€)" style="flex: 1;">
                    </div>
                </div>

                <button type="submit" class="btn-submit">Enregistrer le produit</button>
            </form>
        </div>
    </main>
</body>
</html>
