<?php
// Inclure le fichier de configuration qui établit la connexion à la base de données
include ("config.php");  // Assurez-vous que $conn est maintenant un objet PDO

// Préparer et exécuter la requête
$statement = $conn->prepare("SELECT * FROM `categorie_produits`");
$statement->execute();

// Vérifier si des lignes ont été retournées
if ($statement->rowCount() > 0) {
    // Récupérer et afficher les données de chaque ligne
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
        echo "<option value='" . $row['id_cat'] . "'>" . $row['nom_cat'] . "</option>";
    }
} else {
    echo "<option value=''>0 results</option>";
}

// Fermeture de la connexion à la base de données
$conn = null;
?>
