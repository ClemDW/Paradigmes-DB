<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../src/bootstrap.php';

use toubeelib\praticien\core\Domaine\Entity\MotifVisite;
use toubeelib\praticien\core\Domaine\Entity\Praticien;
use toubeelib\praticien\core\Domaine\Entity\Specialite;
use toubeelib\praticien\core\Domaine\Entity\Structure;
use Ramsey\Uuid\Uuid;
use Doctrine\Common\Collections\Criteria;

$specialiteRepository = $entityManager->getRepository(Specialite::class);

$specialiteID1 = $specialiteRepository->find(1);

echo "Excercice 1 <br>";
echo "1) <br>";
if ($specialiteID1) {
    echo "ID: " . $specialiteID1->getId() . "<br>";
    echo "Libellé: " . $specialiteID1->getLibelle() . "<br>";
    echo "Description: " . $specialiteID1->getDescription() . "<br>";
} else {
    echo "Spécialité avec l'ID 1 non trouvée. <br>";
}




$pratricienRepository = $entityManager->getRepository(Praticien::class);
$praticien = $pratricienRepository->find("8ae1400f-d46d-3b50-b356-269f776be532");
echo "<br> 2) <br>";
if ($praticien) {
    echo "ID: " . $praticien->getId() . "<br>";
    echo "Nom: " . $praticien->getNom() . "<br>";
    echo "Prénom: " . $praticien->getPrenom() . "<br>";
    echo "Ville: " . $praticien->getVille() . "<br>";
    echo "Email: " . $praticien->getEmail() . "<br>";
    echo "Téléphone: " . $praticien->getTelephone() . "<br>";
} else {
    echo "Praticien non trouvé. <br>";
}




$praticien2 = $pratricienRepository->find("8ae1400f-d46d-3b50-b356-269f776be532");
echo "<br> 3) <br>";
if ($praticien2) {
    echo "ID: " . $praticien2->getId() . "<br>";
    echo "Nom: " . $praticien2->getNom() . "<br>";
    echo "Prénom: " . $praticien2->getPrenom() . "<br>";
    echo "Ville: " . $praticien2->getVille() . "<br>";
    echo "Email: " . $praticien2->getEmail() . "<br>";
    echo "Téléphone: " . $praticien2->getTelephone() . "<br>";
    $specialite = $praticien2->getSpecialite();
    echo "Spécialité: " . $specialite->getLibelle() . " (ID: " . $specialite->getId() . ")<br>";

    $structure = $praticien2->getStructure();
    if ($structure) {
        echo "Structure: " . $structure->getNom() . " - " . $structure->getVille() . "<br>";
    } else {
        echo "Structure: Aucune structure associée<br>";
    }
} else {
    echo "Praticien non trouvé. <br>";
}




$structureRepository = $entityManager->getRepository(Structure::class);
$structure = $structureRepository->find("3444bdd2-8783-3aed-9a5e-4d298d2a2d7c");
echo "<br> 4) <br>";
echo "<h3>Structure qui a l'id : 3444bdd2-8783-3aed-9a5e-4d298d2a2d7c</h3>";
if ($structure) {
    echo "Nom: " . $structure->getNom() . "<br>";
    echo "Ville: " . $structure->getVille() . "<br><br>";

    echo "<b>Praticiens de la structure : </b><br>";
    foreach ($structure->getPraticiens() as $praticien) {
        echo $praticien->getNom() . " ";
        echo $praticien->getPrenom() . "<br>";
    }
} else {
    echo "Structure non trouvé. <br>";
}





echo "<br> 5) <br>";
$specialite = $specialiteRepository->find(1);

if ($specialite) {
    echo "<h3>Spécialité</h3>";
    echo "ID: " . $specialite->getId() . "<br>";
    echo "Libellé: " . $specialite->getLibelle() . "<br>";
    echo "Description: " . ($specialite->getDescription() ?? "Aucune description") . "<br>";

    echo "<b>Motifs de visite associés à cette spécialité</b><br>";
    foreach ($specialite->getMotifsVisite() as $motif) {
        echo "ID: " . $motif->getId() . " - ";
        echo "Libellé: " . $motif->getLibelle() . "<br>";
    }
} else {
    echo "Spécialité avec l'ID 1 non trouvée.";
}




echo "<br>6)<br>";
$praticien = $pratricienRepository->find("8ae1400f-d46d-3b50-b356-269f776be532");

if ($praticien) {
    echo "<h3>Informations du praticien</h3>";
    echo "ID: " . $praticien->getId() . "<br>";
    echo "Nom: " . $praticien->getTitre() . " " . $praticien->getPrenom() . " " . $praticien->getNom() . "<br>";
    echo "Ville: " . $praticien->getVille() . "<br>";
    echo "Email: " . $praticien->getEmail() . "<br>";
    echo "Téléphone: " . $praticien->getTelephone() . "<br>";
    echo "Spécialité: " . $praticien->getSpecialite()->getLibelle() . "<br><br>";

    echo "<b>Motifs de visite acceptés par ce praticien</b><br>";
    foreach ($praticien->getMotifsVisite() as $motif) {
        echo $motif->getLibelle();
        echo " (Spécialité: " . $motif->getSpecialite()->getLibelle() . ")<br>";
    }
} else {
    echo "Praticien avec l'ID 8ae1400f-d46d-3b50-b356-269f776be532 non trouvé.";
}





echo "<br>7)<br>";
// 1. Récupérer la spécialité Pédiatrie
$specialite = $specialiteRepository->find(3);

if (!$specialite) {
    echo "La spécialité 'Pédiatrie' n'existe pas.";
}

// 2. Créer le praticien
$praticien = new Praticien(
    nom: "Dupond",
    rpps_id: "12345678901",
    prenom: "Xavier",
    titre: "Dr.",
    ville: "Nante",
    email: "xavier.dupond@example.com",
    telephone: "04 72 00 00 00",
);

// 3. Définir l'ID et la spécialité
$UuidPraticien = Uuid::uuid4()->toString();
$praticien->setId($UuidPraticien);
$praticien->setSpecialite($specialite);

// 4. Sauvegarder
$entityManager->persist($praticien);
$entityManager->flush();

// 5. Recherche
$praticien = $pratricienRepository->find($UuidPraticien);
if ($praticien) {
    echo "ID: " . $praticien->getId() . "<br>";
    echo "Nom: " . $praticien->getNom() . "<br>";
    echo "Prénom: " . $praticien->getPrenom() . "<br>";
    echo "Ville: " . $praticien->getVille() . "<br>";
    echo "Email: " . $praticien->getEmail() . "<br>";
    echo "Téléphone: " . $praticien->getTelephone() . "<br>";
    echo "Spécialité: " . $praticien->getSpecialite()->getLibelle() . "<br>";
} else {
    echo "Praticien non trouvé. <br>";
}




echo "<br>8)<br>";
$praticien = $pratricienRepository->find($UuidPraticien);
$praticien->setStructure($structureRepository->find('3444bdd2-8783-3aed-9a5e-4d298d2a2d7c'));
$praticien->setVille("Paris");
$motifRepository = $entityManager->getRepository(MotifVisite::class);
$motif1 = $motifRepository->find(12);
$motif2 = $motifRepository->find(13);
$motif3 = $motifRepository->find(14);
/*$motif1->addPraticien($praticien);
$motif2->addPraticien($praticien);
$motif3->addPraticien($praticien);
$praticien->addMotifVisite($motif1);
$praticien->addMotifVisite($motif2);
$praticien->addMotifVisite($motif3);
$entityManager->flush();*/



$praticien = $pratricienRepository->find($UuidPraticien);
if ($praticien) {
    echo "ID: " . $praticien->getId() . "<br>";
    echo "Nom: " . $praticien->getNom() . "<br>";
    echo "Prénom: " . $praticien->getPrenom() . "<br>";
    echo "Ville: " . $praticien->getVille() . "<br>";
    echo "Email: " . $praticien->getEmail() . "<br>";
    echo "Téléphone: " . $praticien->getTelephone() . "<br>";
    echo "Spécialité: " . $praticien->getSpecialite()->getLibelle() . "<br>";

    /*echo "<b>Motifs de visite acceptés par ce praticien</b><br>";
    foreach ($praticien->getMotifsVisite() as $motif) {
        echo $motif->getLibelle();
        echo " (Spécialité: " . $motif->getSpecialite()->getLibelle() . ")<br>";
    }*/

    echo "<b>Structure du patricien</b><br>";
    $structure = $praticien2->getStructure();
    if ($structure) {
        echo "Structure: " . $structure->getNom() . " - " . $structure->getVille() . "<br>";
    } else {
        echo "Structure: Aucune structure associée<br>";
    }
} else {
    echo "Praticien non trouvé. <br>";
}





echo "<br>9)<br>";
$praticien = $pratricienRepository->find($UuidPraticien);
$entityManager->remove($praticien);
$entityManager->flush();

$praticien = $pratricienRepository->find($UuidPraticien);
if ($praticien) {
    echo "ID: " . $praticien->getId() . "<br>";
    echo "Nom: " . $praticien->getNom() . "<br>";
    echo "Prénom: " . $praticien->getPrenom() . "<br>";
    echo "Ville: " . $praticien->getVille() . "<br>";
} else {
    echo "Praticien non trouvé. <br>";
}




echo "<br><h2>Exercice 2</h2>";
echo "1)<br>";
$praticien = $pratricienRepository->findOneBy(["email" => "Gabrielle.Klein@live.com"]);
if ($praticien) {
    echo "ID: " . $praticien->getId() . "<br>";
    echo "Nom: " . $praticien->getNom() . "<br>";
    echo "Prénom: " . $praticien->getPrenom() . "<br>";
    echo "Ville: " . $praticien->getVille() . "<br>";
} else {
    echo "Praticien non trouvé. <br>";
}




echo "<br>2)<br>";
$praticien = $pratricienRepository->findOneBy(["nom" => "Goncalves", "ville" => "Paris"]);
if ($praticien) {
    echo "ID: " . $praticien->getId() . "<br>";
    echo "Nom: " . $praticien->getNom() . "<br>";
    echo "Prénom: " . $praticien->getPrenom() . "<br>";
    echo "Ville: " . $praticien->getVille() . "<br>";
} else {
    echo "Praticien non trouvé. <br>";
}





echo "<br>3)<br>";
$specialite = $specialiteRepository->findOneBy(["libelle" => "pédiatrie"]);
if ($specialite) {
    echo "<b>Spécialité</b><br>";
    echo "ID: " . $specialite->getId() . "<br>";
    echo "Libellé: " . $specialite->getLibelle() . "<br>";
    echo "Description: " . ($specialite->getDescription() ?? "Aucune description") . "<br>";

    echo "<b>Praticiens associés à cette spécialité</b><br>";
    foreach ($specialite->getPraticiens() as $praticien) {
        echo "Nom: " . $praticien->getNom() . "<br>";
        echo "Prénom: " . $praticien->getPrenom() . "<br>";
        echo "Ville: " . $praticien->getVille() . "<br>";
        echo "<br>";
    }
} else {
    echo "Spécialité avec l'ID 1 non trouvée.";
}

echo "<br>4)<br>";
$criteria = Criteria::create()
    ->where(Criteria::expr()->contains("nom", "Santé"));
$structuresSante = $structureRepository->matching($criteria);
echo "<b>Structures contenant 'santé' :</b><br>";
foreach ($structuresSante as $struct) {
    echo $struct->getNom() . " (" . $struct->getVille() . ")<br>";
}

echo "<br>5)<br>";
$specialite = $specialiteRepository->findOneBy(['libelle' => 'ophtalmologie']);
if ($specialite) {
    foreach ($specialite->getPraticiens() as $praticien) {
        if ($praticien->getVille() === "Paris") {
            echo "Nom: " . $praticien->getNom() . "<br>";
            echo "Prénom: " . $praticien->getPrenom() . "<br>";
            echo "Ville: " . $praticien->getVille() . "<br>";
            echo "<br>";
        }
    }
}

echo "<br><h2>Exercice 3</h2><br>";
echo "1)<br> Recherche de spécialités par mot-clé 'médecine' :<br>";
$res1 = $specialiteRepository->findByKeyword("médecine");
foreach ($res1 as $spec) {
    echo "ID: " . $spec->getId() . " - Libellé: " . $spec->getLibelle() . "<br>";
}

echo "<br>2)<br> Praticiens dont la spécialité contient 'pédiatrie' :<br>";
$res2 = $pratricienRepository->findBySpecialtyKeyword("pédiatrie");
foreach ($res2 as $p) {
    echo "Nom: " . $p->getNom() . " - Spécialité: " . $p->getSpecialite()->getLibelle() . "<br>";
}

echo "<br>3)<br> Praticiens spécialité 1 (Médecine générale) acceptant 'chèque' :<br>";
$res3 = $pratricienRepository->findBySpecialtyAndPayment(1, "chèque");
foreach ($res3 as $p) {
    echo "Nom: " . $p->getNom() . "<br>";
}
