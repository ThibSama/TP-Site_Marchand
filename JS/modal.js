function openModal(imageData) {
    const modal = document.getElementById('modal');
    const modalImage = document.getElementById('modal-image');
    modalImage.src = 'data:image/jpeg;base64,' + imageData;
    modal.classList.add('open');
}

function closeModal() {
    const modal = document.getElementById('modal');
    modal.classList.remove('open');
}