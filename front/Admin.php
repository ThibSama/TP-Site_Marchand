<?php
// Inclusion du fichier header.php qui contient le début du code HTML et les éléments d'en-tête
global $conn;
include '../back/php/header.php';
?>

    <section class="container mx-auto mt-6 p-6 bg-white rounded-lg shadow-md overflow-x-auto">
        <h2 class="text-4xl font-semibold mb-6">Panneau d'administration</h2>

        <form name="addForm" action="../back/php/add_product.php" method="post" enctype="multipart/form-data" onsubmit="return validation_ajout()">
            <div class="mb-4">
                <label for="nom_produits" class="block text-xl font-medium mb-2">Nom:</label>
                <input type="text" name="nom_produits" class="p-2 w-full rounded border border-gray-300">
            </div>

            <div class="mb-4">
                <label for="desc_produits" class="block text-xl font-medium mb-2">Description:</label>
                <input type="text" name="desc_produits" class="p-2 w-full rounded border border-gray-300">
            </div>

            <div class="mb-4">
                <label for="prix_produits" class="block text-xl font-medium mb-2">Prix:</label>
                <input type="text" name="prix_produits" class="p-2 w-full rounded border border-gray-300">
            </div>

            <div class="mb-4">
                <label for="categorie_produits" class="block text-xl font-medium mb-2">Catégorie:</label>
                <select 
                    class="p-2 w-full rounded border border-gray-300u" 
                    id="categorie_produits" 
                    name="categorie_produits">
                        <?php include '../back/php/volet_produits.php'; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="img_produits" class="block text-xl font-medium mb-2">Image:</label>
                <input type="file" name="img_produits" id="img_produits" class="p-2 w-full rounded border border-gray-300">
            </div>

            <div>
                <a href="../front/Admin.php" class="href">
                    <input type="submit" value="Ajouter produit" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-lg">
                </a>
            </div>
        </form>
        </div>

        <table class="mt-6 w-full text-lg border min-w-full">
            <thead>
                <tr>
                    <th class="border p-2">Image</th>
                    <th class="border p-2">Nom du produit</th>
                    <th class="border p-2">Description</th>
                    <th class="border p-2">Catégorie</th>
                    <th class="border p-2">Prix</th>
                    <th class="border p-2">Actions</th>
                </tr>
            </thead>
            <?php
            // Inclusion du fichier de configuration pour établir la connexion à la base de données
            include '../back/php/config.php';

            // Vérification de l'état de la connexion à la base de données
            if ($conn === null) {
                die("La variable pdo est null"); // Arrête le script si la connexion est nulle
            }

            // Récupération des produits de la base de données
            $stmt = $conn->query('SELECT * FROM produits p INNER JOIN categorie_produits c ON p.id_cat = c.id_cat');

            while ($row = $stmt->fetch()) { // Boucle à travers chaque produit retourné
                echo '<tr>';

                // Affichage de l'image du produit en format base64
                echo '<td class="border p-2"><img src="data:image/jpeg;base64,' . base64_encode($row['img_produits']) . '" width="100" height="100"/></td>';

                // Affichage du nom du produit
                echo '<td class="border p-2">' . $row['nom_produits'] . '</td>';

                // Affichage de la description du produit
                echo '<td class="border p-2">' . $row['desc_produits'] . '</td>';

                echo '<td class="border p-2">' . $row['nom_cat'] . '</td>';

                // Affichage du prix du produit
                echo '<td class="border p-2">' . $row['prix_produits'] . '€</td>';
                echo '<td class="border p-2">';
                echo '<a href="edit_product.php?id_produits=' . $row['id_produits'] . '" class="bg-yellow-400 text-white p-2 rounded-lg">Modifier</a> ';
                echo '<a href="../back/php/delete_product.php?id=' . $row['id_produits'] . '" class="bg-red-400 text-white p-2 rounded-lg">Supprimer</a>';
                echo '</td>';
            }
            ?>
        </table>
    </section>

    <?php
    // Inclusion du fichier footer.php qui contient la fin du code HTML et les éléments de pied de page
    include '../back/php/footer.php';
    ?>