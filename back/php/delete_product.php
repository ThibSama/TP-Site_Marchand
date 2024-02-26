<?php
// Inclure le fichier de configuration qui établit la connexion à la base de données
include './config.php';
    
    // Récupérer l'ID du produit à partir de l'URL
    $id = $_GET['id'];
    
    // Vérifier si l'ID n'est pas vide
    if (!empty($id)) {
        // Préparer une requête pour supprimer le produit ayant l'ID spécifié
        $stmt = $conn->prepare("DELETE FROM produits WHERE id_produits = :id");
        
        // Associer l'ID à la requête préparée
        $stmt->bindParam(':id', $id);
        
        // Exécuter la requête
        $stmt->execute();
        
        // Rediriger l'utilisateur vers la page admin.php après la suppression du produit
        header("Location:../../front/admin.php");
    }
?>
