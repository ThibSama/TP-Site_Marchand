function validation_ajout() {
    var nom = document.forms["addForm"]["nom_produits"].value;
    var desc = document.forms["addForm"]["desc_produits"].value;
    var prix = document.forms["addForm"]["prix_produits"].value;
    var img = document.forms["addForm"]["img_produits"].value;

    if (nom == "" || desc == "" || prix == "" || img == "") {
        alert("Tous les champs sont obligatoires.");
        return false;
    }

    if (isNaN(prix) || prix < 0) {
        alert("Le prix doit être un nombre positif.");
        return false;
    }
}

function validation_edit() {
    var nom = document.forms["editForm"]["nom_produits"].value;
    var desc = document.forms["editForm"]["desc_produits"].value;
    var prix = document.forms["editForm"]["prix_produits"].value;

    if (nom == "" || desc == "" || prix == "") {
        alert("Tous les champs sont obligatoires.");
        return false;
    }

    if (isNaN(prix) || prix < 0) {
        alert("Le prix doit être un nombre positif.");
        return false;
    }
}
