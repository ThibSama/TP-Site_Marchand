<?php
// Inclure le fichier header qui contient l'entête de la page
include '../back/php/header.php';

// Inclure le fichier de configuration pour se connecter à la base de données
include '../back/php/config.php';

// Vérifier si la connexion à la base de données est établie
if ($conn === null) {
    die("La connexion à la base de données n'est pas établie."); 
}

// Déterminer la page actuelle
// $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
// $limit = 9; // Limiter le nombre de produits par page
// $offset = ($page - 1) * $limit;

// Calculer le nombre total de produits
// $totalQuery = "SELECT COUNT(*) as count FROM produits";
// $totalResult = $conn->query($totalQuery);
// $totalRow = $totalResult->fetch(PDO::FETCH_ASSOC);
// $totalProducts = $totalRow['count'];

// Modifier la requête pour afficher seulement 3 produits à la fois
$query = "SELECT * FROM produits"; 
// LIMIT $limit OFFSET $offset
$result = $conn->query($query);

if (!$result) {
    die("Erreur lors de l'exécution de la requête : " . $conn->errorInfo());
}
?>

<!-- Section principale pour afficher les produits -->
<section class="container mx-auto mt-6 p-6 bg-white rounded-lg shadow-md overflow-x-auto">
    <h2 class="text-4xl font-semibold mb-6">Produits</h2>

    <!-- Sélection pour trier les produits -->
    <select id="sortSelect">
        <option value="nom">Trier par Nom</option>
        <option value="prixAsc">Trier par Prix Croissant</option>
        <option value="prixDesc">Trier par Prix Décroissant</option>
    </select>

    <!-- Grille pour afficher les produits -->
    <div class="grid grid-cols-3 gap-4">
    <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)) { ?>
    <div class="product-item border-t flex flex-col inline-bloc">
            <!-- Affichage de l'image du produit -->
            <div class="p-4 h-auto w-48 flex-shrink-0">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($row['img_produits']); ?>" alt="<?php echo $row['nom_produits']; ?>" class="w-full object-cover cursor-pointer transform transition-transform duration-300 hover:scale-110" onclick="openModal('<?php echo base64_encode($row['img_produits']); ?>')">
            </div>
            <!-- Description et prix du produit -->
            <div class="p-4 flex-grow flex flex-col justify-between">
                <div>
                    <h3 class="text-xl font-semibold transition-colors duration-300 hover:text-indigo-500">
                        <?php echo $row['nom_produits']; ?>
                    </h3>
                    <p class="text-gray-700 transition-opacity duration-300 hover:opacity-80">
                        <?php echo $row['desc_produits']; ?>
                    </p>
                </div>
                <div class="mt-4">
                    <span class="text-lg font-bold transition-transform duration-300 transform hover:scale-110">
                        <?php echo $row['prix_produits']; ?>€
                    </span>
                </div>
            </div>
        </div>
    <?php } ?>
    </div>
    <!-- Boutons pour naviguer entre les pages de produits -->
    <!-- <div class="flex justify-between mt-4">
        <button id="prevBtn" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full">Précédent</button>
        <button id="nextBtn" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full">Suivant</button>
    </div> -->
</section>

<div id="modal" class="modal fixed top-0 left-0 w-full h-full flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="modal-content bg-white rounded-lg p-4 h-auto w-auto">
        <button onclick="closeModal()" class="text-red-500 text-xl close-modal">×</button>
        <img id="modal-image" class="w-full h-full object-cover mt-4">
    </div>
</div>

<?php
// Inclusion du fichier footer.php qui contient la fin du code HTML et les éléments de pied de page
include '../back/php/footer.php';
?>