<?php
// Fonction pour récupérer l'image d'un produit depuis la base de données
function getImageFromDB($id_produits, $conn) {
    $stmt = $conn->prepare("SELECT img_produits FROM produits WHERE id_produits = :id_produits");
    $stmt->bindParam(':id_produits', $id_produits, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetch();
    return $result ? $result['img_produits'] : null;
}

// Inclusion du fichier de configuration pour établir la connexion à la base de données
include '../back/php/config.php';

// Tentative de connexion à la base de données
try {
    // Le code pour se connecter à la base de données est normalement dans config.php
    // Donc rien à ajouter ici
} catch (PDOException $e) {
    echo "Erreur : ";
    switch ($e->getCode()) {
        case 1049:
            echo "Base de données inconnue.";
            break;
        case 1045:
            echo "Identifiant ou mot de passe incorrect.";
            break;
        case 2002:
            echo "Impossible de se connecter au serveur de base de données.";
            break;
        default:
            echo $e->getMessage();
            break;
    }
    exit;  // Termine le script
}

if ($conn === null) {
    die("La connexion a échoué.");
}

$id_produits = $_GET['id_produits'] ?? null;

if ($id_produits === null) {
    die("Aucun ID de produit fourni.");
}

$stmt = $conn->prepare("SELECT * FROM produits p 
INNER JOIN categorie_produits c ON p.id_cat = c.id_cat
WHERE id_produits = :id_produits");
$stmt->bindParam(':id_produits', $id_produits, PDO::PARAM_INT);
$stmt->execute();

if ($stmt->errorCode() != "00000") {
    die("Erreur SQL : " . $stmt->errorInfo()[2]);
}

if ($stmt->rowCount() == 0) {
    die("Produit non trouvé.");
}

$product = $stmt->fetch(PDO::FETCH_ASSOC);

if ($product !== false) {
    $nom_produits = $product['nom_produits'];
    $desc_produits = $product['desc_produits'];
    $prix_produits = $product['prix_produits'];
    $id_cat = $product['id_cat'];
    $img_produits = base64_encode($product['img_produits']);
} else {
    die("Produit non trouvé");
}

// Traitement de la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // L'ID du produit est déjà défini ci-dessus
    $nom_produits = $_POST['nom_produits'];
    $desc_produits = $_POST['desc_produits'];
    $prix_produits = $_POST['prix_produits'];
    $id_cat = $_POST['categorie_produits'];

    // Vérification si une image a été téléchargée
    if (isset($_FILES['img_produits']) && $_FILES['img_produits']['error'] == 0) {
        $img_produits = file_get_contents($_FILES['img_produits']['tmp_name']);
    } else {
        $img_produits = getImageFromDB($id_produits, $conn);
    }

    $stmt = $conn->prepare("UPDATE produits SET nom_produits = :nom, desc_produits = :desc, prix_produits = :prix, id_cat = :categorie, img_produits = :img WHERE id_produits = :id");
    $stmt->bindParam(':nom', $nom_produits);
    $stmt->bindParam(':desc', $desc_produits);
    $stmt->bindParam(':prix', $prix_produits);
    $stmt->bindParam(':categorie', $id_cat);
    $stmt->bindParam(':img', $img_produits, PDO::PARAM_LOB);
    $stmt->bindParam(':id', $id_produits);

    if ($stmt->execute()) {
        header("Location: admin.php");  // Redirige vers admin.php après la mise à jour
        exit;  // Termine le script
    } else {
        echo "Erreur lors de la mise à jour du produit.";
    }
}

// Inclusion du fichier header.php pour le début du code HTML et l'en-tête
include '../back/php/header.php'; 
?>

    <!-- Main Content -->
    <main class="container mx-auto mt-6 p-6 bg-white rounded-lg shadow-md flex-grow">
        <h2 class="text-4xl font-semibold mb-6">Modifier le produit</h2>

        <form name="editForm" action="" method="post" enctype="multipart/form-data" onsubmit="return validation_edit()">
            <input type="hidden" name="id_produits" value="<?php echo $id_produits; ?>">

            <div class="w-full sm:w-1/2 md:w-1/4 mb-4">
                <label for="nom_produits" class="block text-sm font-medium">Nom:</label>
                <input type="text" name="nom_produits" class="p-2 w-auto rounded-md border border-gray-300" value="<?php echo $nom_produits; ?>">
            </div>

            <div class="w-full sm:w-1/2 md:w-1/4 mb-4">
                <label for="desc_produits" class="block text-sm font-medium">Description:</label>
                <input type="text" name="desc_produits" class="p-2 w-full rounded-md border border-gray-300" value="<?php echo $desc_produits; ?>">
            </div>

            <div class="w-full sm:w-1/2 md:w-1/4 mb-4">
                <label for="prix_produits" class="block text-sm font-medium">Prix:</label>
                <input type="number" name="prix_produits" class="p-2 w-auto rounded-md border border-gray-300" value="<?php echo $prix_produits; ?>">
            </div>  

            <div class="mb-4">
                <label for="categorie_produits" class="block text-sm font-medium">Catégorie:</label>
                <select 
                    class="p-2 w-auto rounded-md border border-gray-300" 
                    id="categorie_produits" 
                    name="categorie_produits">
                        <?php include '../back/php/volet_produits.php'; ?>
                </select>
            </div>

            <div class="w-full sm:w-1/2 md:w-1/4 mb-4">
                <label for="img_produits" class="block text-sm font-medium">Image actuelle:</label>
                <img src="data:image/jpeg;base64,<?php echo $img_produits; ?>" width="100" class="object-contain">
            </div>

            <div class="w-full md:w-1/4 mb-4">
                <label for="img_produits" class="block text-sm font-medium">Nouvelle Image:</label>
                <input type="file" name="img_produits" id="img_produits" class="p-2 w-auto rounded-md border border-gray-300">
            </div>

            <div class="w-full mt-4">
                <input type="submit" value="Mettre à jour" class="bg-green-500 hover:bg-green-600 text-white p-2 mt-6 rounded-lg">
            </div>
        </form>
    </main>
<?php 
// Inclusion du fichier footer.php pour la fin du code HTML et le pied de page
include '../back/php/footer.php'; 
?>