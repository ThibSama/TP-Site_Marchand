document.addEventListener('DOMContentLoaded', () => {
    const carrousel = document.getElementById('carrousel');
    const container = carrousel.querySelector('.flex');
    const items = container.children;
    let index = 0;

    function showNextProduct() {
        if (index < items.length - 1) {
            index++;
        } else {
            index = 0;
        }
        updateCarrousel();
    }

    function showPreviousProduct() {
        if (index > 0) {
            index--;
        } else {
            index = items.length - 1;
        }
        updateCarrousel();
    }

    function updateCarrousel() {
        const newTransformValue = `translateX(-${index * 100}%)`;
        container.style.transform = newTransformValue;
    }

    // Ajout des boutons suivant et précédent si nécessaire
    if (items.length > 1) {
        const nextButton = document.createElement('button');
        nextButton.innerText = 'Suivant';
        nextButton.classList.add('absolute', 'top-1/2', 'right-0', 'transform', '-translate-y-1/2', 'bg-white', 'p-2', 'shadow-md');
        nextButton.addEventListener('click', showNextProduct);
        carrousel.appendChild(nextButton);

        const prevButton = document.createElement('button');
        prevButton.innerText = 'Précédent';
        prevButton.classList.add('absolute', 'top-1/2', 'left-0', 'transform', '-translate-y-1/2', 'bg-white', 'p-2', 'shadow-md');
        prevButton.addEventListener('click', showPreviousProduct);
        carrousel.appendChild(prevButton);
    }
});
