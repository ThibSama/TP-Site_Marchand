<?php
require_once('../back/php/header.php');
require_once('../back/php/config.php');

try {
    // Récupération des meilleurs produits par rapport aux notes
    $sqlBestProducts = "SELECT p.nom_produits, AVG(n.note) as moyenne_note
                        FROM produits p
                        JOIN note n ON p.id_produits = n.id_produits
                        GROUP BY p.id_produits
                        ORDER BY moyenne_note DESC
                        LIMIT 5"; // Top 5 produits
    $stmtBestProducts = $conn->query($sqlBestProducts);
    $bestProducts = $stmtBestProducts->fetchAll(PDO::FETCH_ASSOC);


    $sqlAllProducts = "SELECT p.nom_produits, AVG(n.note) as moyenne_note
                   FROM produits p
                   JOIN note n ON p.id_produits = n.id_produits
                   GROUP BY p.id_produits
                   ORDER BY moyenne_note DESC";
$stmtAllProducts = $conn->query($sqlAllProducts);
$allProducts = $stmtAllProducts->fetchAll(PDO::FETCH_ASSOC);


    // Récupération des catégories de produits
    $sqlCategories = "SELECT id_cat, nom_cat FROM categorie_produits";
    $stmtCategories = $conn->query($sqlCategories);
    $categories = $stmtCategories->fetchAll(PDO::FETCH_ASSOC);

    $dataCategories = [];
    foreach ($categories as $category) {
        $sqlCategoryProducts = "SELECT p.nom_produits, AVG(n.note) as moyenne_note
                                FROM produits p
                                JOIN note n ON p.id_produits = n.id_produits
                                WHERE p.id_cat = ?
                                GROUP BY p.id_produits
                                ORDER BY moyenne_note DESC
                                LIMIT 5"; // Top 5 produits par catégorie
        $stmtCategoryProducts = $conn->prepare($sqlCategoryProducts);
        $stmtCategoryProducts->execute([$category['id_cat']]);
        $categoryProducts = $stmtCategoryProducts->fetchAll(PDO::FETCH_ASSOC);
        $dataCategories[$category['nom_cat']] = $categoryProducts;
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}

?>

<main class="container mx-auto mt-6 p-6 bg-white rounded-lg shadow-md flex-grow">

    <h2 class="text-2xl font-semibold mb-6">Statistiques des produits</h2>

    <div class="flex flex-wrap -mx-4">
        
        <!-- Graphique pour les meilleurs produits -->
        <div class="w-1/2 px-4 my-6">
            <h3 class="text-lg font-semibold mb-4">Top 5 produits</h3>
            <canvas id="chartBestProducts"></canvas>
        </div>

        <!-- Graphiques pour chaque catégorie de produits -->
        <?php foreach ($dataCategories as $categoryName => $products): ?>
            <div class="w-1/2 px-4 my-6">
                <h3 class="text-lg font-semibold mb-4"><?php echo htmlspecialchars($categoryName); ?></h3>
                <canvas id="chartCategory_<?php echo htmlspecialchars($categoryName); ?>"></canvas>
            </div>
        <?php endforeach; ?>

        <div id="allProductsTable"></div>

    </div>

</main>

<table class="w-full text-left border-collapse">
    <thead>
        <tr>
            <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Nom du Produit</th>
            <th class="py-2 px-4 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Moyenne des Notes</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($allProducts as $product): ?>
        <tr>
            <td class="py-2 px-4 border-b border-grey-light"><?php echo htmlspecialchars($product['nom_produits']); ?></td>
            <td class="py-2 px-4 border-b border-grey-light"><?php echo number_format($product['moyenne_note'], 2); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Données pour le graphique des meilleurs produits
    var bestProductsData = {
        labels: [<?php foreach ($bestProducts as $product) echo '"' . $product['nom_produits'] . '",'; ?>],
        datasets: [{
            data: [<?php foreach ($bestProducts as $product) echo $product['moyenne_note'] . ','; ?>],
            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
        }]
    };
    var ctxBestProducts = document.getElementById('chartBestProducts').getContext('2d');
    var chartBestProducts = new Chart(ctxBestProducts, {
        type: 'pie',
        data: bestProductsData,
    });

    // Données pour le graphique de chaque catégorie
    <?php foreach ($dataCategories as $categoryName => $products): ?>
        var categoryData = {
            labels: [<?php foreach ($products as $product) echo '"' . $product['nom_produits'] . '",'; ?>],
            datasets: [{
                data: [<?php foreach ($products as $product) echo $product['moyenne_note'] . ','; ?>],
                backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'],
            }]
        };
        var ctxCategory = document.getElementById('chartCategory_<?php echo htmlspecialchars($categoryName); ?>').getContext('2d');
        var chartCategory = new Chart(ctxCategory, {
            type: 'pie',
            data: categoryData,
        });
    <?php endforeach; ?>

    function generateProductTable(products) {
    var tableHTML = '<table border="1"><thead><tr><th>Nom Produit</th><th>Note Moyenne</th></tr></thead><tbody>';
    for(var i=0; i<products.length; i++) {
        tableHTML += '<tr><td>' + products[i].nom_produits + '</td><td>' + products[i].moyenne_note + '</td></tr>';
    }
    tableHTML += '</tbody></table>';
    document.getElementById('allProductsTable').innerHTML = tableHTML;
}

</script>

<?php
include '../back/php/footer.php';
?>
