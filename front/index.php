<?php
// Inclusion du fichier header.php qui contient le début du code HTML et les éléments d'en-tête
require_once ( '../back/php/header.php');
require_once ('../back/php/config.php');

try {
    // Requête SQL pour obtenir les trois produits en vedette
    $sql = "SELECT p.id_produits, p.nom_produits, p.desc_produits, p.prix_produits, AVG(n.note) as moyenne_note
            FROM produits p
            JOIN note n ON p.id_produits = n.id_produits
            GROUP BY p.id_produits
            ORDER BY moyenne_note DESC
            LIMIT 3";
    $stmt = $conn->query($sql);

    // Récupération des résultats
    $produitsEnVedette = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>


</div>
<!-- Main Content -->
<main class="mt-6 container mx-auto mt-6 p-6 bg-white rounded-lg shadow-md flex-grow">

<div id="carrousel" class="mt-8">
    <div class="flex overflow-hidden">
        <?php foreach ($produitsEnVedette as $produit): ?>
            <div class="flex-none w-full p-4">
                <div class="border rounded-lg p-4">
                    <h3 class="text-lg font-semibold"><?php echo htmlspecialchars($produit['nom_produits']); ?></h3>
                    <p class="text-gray-600"><?php echo htmlspecialchars($produit['desc_produits']); ?></p>
                    <p class="mt-2 text-gray-900 font-semibold"><?php echo htmlspecialchars(number_format($produit['prix_produits'], 2, ',', ' ')); ?> €</p>
                    <p class="mt-1 text-sm text-gray-600">Note moyenne: <?php echo htmlspecialchars(number_format($produit['moyenne_note'], 2)); ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

  <h2 class="text-2xl sm:text-4xl font-semibold mb-6">Mr. Serano et la quête de l'eau</h2>

  <p class="text-lg sm:text-xl text-gray-700 mb-4">
    Alors qu'il gérait sa boutique de souvenirs autour du jeu Genshin Impact, Mr. Serano est tombé sur une vidéo de Jean-Claude Van Damme alertant sur le manque d'eau futur de notre planète.
  </p>

  <p class="text-lg sm:text-xl text-gray-700 mb-4">
    Inspiré par cette révélation, Mr. Serano a alors décidé de diversifier son offre en vendant de l'eau. Non pas n'importe quelle eau, mais une sélection d'eaux rares et précieuses, chacune avec sa propre histoire et ses propriétés uniques.
  </p>

  <p class="text-lg sm:text-xl text-gray-700 mb-4">
    "L'eau, c'est la vie, et chaque goutte compte", déclare Mr. Serano. "Si Jean-Claude peut sensibiliser le monde à l'importance de cette ressource, alors je me dois de contribuer à ma façon."
  </p>

  <p class="text-lg sm:text-xl text-gray-700">
    Il parcourt désormais le monde à la recherche des meilleures sources, proposant ainsi à ses clients une expérience de dégustation d'eau totalement unique.
  </p>
</main>

<?php
// Inclusion du fichier footer.php pour la fin du code HTML et le pied de page
include '../back/php/footer.php';
?>