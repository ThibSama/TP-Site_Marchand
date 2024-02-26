<?php
// Inclure le fichier de configuration pour la base de données
include './config.php';
if (isset($conn)) {
    echo "Connexion établie.";
} else {
    echo "Connexion non établie.";
}

// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_produits = $_POST['nom_produits'];
    $desc_produits = $_POST['desc_produits'];
    $prix_produits = $_POST['prix_produits'];

    // Pour l'image, c'est un peu plus compliqué car c'est un fichier
    $img_produits = file_get_contents($_FILES['img_produits']['tmp_name']);

    if ($img_produits) {
        // L'image a été lue avec succès, continuez avec l'insertion
        try {
            $sql = "INSERT INTO produits (nom_produits, desc_produits, prix_produits, img_produits) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(1, $nom_produits);
            $stmt->bindParam(2, $desc_produits);
            $stmt->bindParam(3, $prix_produits);
            $stmt->bindParam(4, $img_produits, PDO::PARAM_LOB);
            $stmt->execute();

            header("Location:../../front/admin.php");
            exit; // Redirige vers le panneau d'administration
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    } else {
        echo "Erreur lors de la lecture de l'image.";
    }
}
?>
