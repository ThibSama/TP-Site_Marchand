document.getElementById("sortSelect").addEventListener("change", function() {
    const products = document.querySelectorAll(".product-item");
    const productsArray = Array.from(products);
    const sortedProducts = sortProducts(productsArray, this.value);

    const container = document.querySelector(".grid.grid-cols-3");
    container.innerHTML = "";
    sortedProducts.forEach(product => {
        container.appendChild(product);
    });
});

function sortProducts(products, criterion) {
    switch(criterion) {
        case "nom":
            return products.sort((a, b) => {
                const nameA = a.querySelector("h3").textContent.trim();
                const nameB = b.querySelector("h3").textContent.trim();
                return nameA.localeCompare(nameB);
            });
        case "prixAsc":
            return products.sort((a, b) => {
                const priceA = parseFloat(a.querySelector("span").textContent.trim().replace("€", ""));
                const priceB = parseFloat(b.querySelector("span").textContent.trim().replace("€", ""));
                return priceA - priceB;
            });
        case "prixDesc":
            return products.sort((a, b) => {
                const priceA = parseFloat(a.querySelector("span").textContent.trim().replace("€", ""));
                const priceB = parseFloat(b.querySelector("span").textContent.trim().replace("€", ""));
                return priceB - priceA;
            });
        default:
            return products;
    }
}
